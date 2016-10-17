(function($, _) {
  function resetForm(form) {
      // clearing inputs
      var inputs = form.getElementsByTagName('input');
      for (var i = 0; i<inputs.length; i++) {
          switch (inputs[i].type) {
              // case 'hidden':
              case 'text':
                  inputs[i].value = '';
                  break;
              case 'radio':
              case 'checkbox':
                  inputs[i].checked = false;
          }
      }

      // clearing selects
      var selects = form.getElementsByTagName('select');
      for (var i = 0; i<selects.length; i++)
          selects[i].selectedIndex = 0;

      // clearing textarea
      var text= form.getElementsByTagName('textarea');
      for (var i = 0; i<text.length; i++)
          text[i].innerHTML= '';

      return false;
  }

  jQuery('#limpar').on('click', function () {
    resetForm(document.getElementById('filtrosContribuicao'));
  });


  _.mixin({
    currency: function(string) {
      return 'R$ '+(string/100).toFixed(2);
    },
    status : function(string) {
      if (string =='1') {
        return 'Transação autorizada';
      } else if (string == '2') {
        return 'Autorização negada';
      } else {
        return 'Informação indisponível';
      }
    }
  });

  var ActionCell = Backgrid.ActionCell = Backgrid.Cell.extend({
    /** @property */
    className: "action-cell",

    /**
       @property {string} [title] The title attribute of the generated anchor. It
       uses the display value formatted by the `formatter.fromRaw` by default.
    */
    title: null,

    /**
       @property {string} [target="_blank"] The target attribute of the generated
       anchor.
    */
    target: "_blank",

    initialize: function (options) {
      ActionCell.__super__.initialize.apply(this, arguments);
      this.title = options.title || this.title;
      this.target = options.target || this.target;
    },

    render: function () {
      this.$el.empty();
      var rawValue = this.model.get(this.column.get("name"));
      var formattedValue = this.formatter.fromRaw(rawValue, this.model);

      if ( rawValue !== null ) {
        this.$el.append($("<a>", {
          tabIndex: -1,
          href: rawValue,
          title: this.title || formattedValue,
          target: this.target
        }).text('Abrir'));
        this.delegateEvents();
      } else {
        this.$el.text('-');
      }

      return this;
    }

  });

  var Contribuicao = Backbone.Model.extend({});

  var Contribuicoes = Backbone.PageableCollection.extend({
    model: Contribuicao,
    url: RS_API_PAYMENTS,
      state: {
        firstPage: 0
      }
  });

  var contribuicoes = new Contribuicoes();

  var columns = [
    {
      name: "payments.user_id",
      label: "ID Usuário",
      editable: false,
      cell: "string"
    },
    {
      name: "afiliados.fullname",
      label: "Nome Completo",
      editable: false,
      cell: "string"
    },
    {
      name: "afiliados.cpf",
      label: "CPF",
      editable: false,
      cell: "string",
    },
    {
      name: "afiliados.uf",
      label: "UF",
      editable: false,
      cell: "string"
    },
    {
      name: "afiliados.cidade",
      label: "Cidade",
      editable: false,
      cell: "string"
    },
    {
      name: "payments.status",
      label: "Status",
      editable: false,
      cell: "string",
      formatter: _.extend({}, Backgrid.CellFormatter.prototype, {
        fromRaw: function (rawValue, model) {
          return _(rawValue).status();
        }
      })
    },
    {
      name: "payments.boleto_url",
      label: "Link Boleto",
      editable: false,
      cell: "action"
    },
    {
      name: "dados_contribuicoes.tipo",
      label: "Forma Pagamento",
      editable: false,
      cell: "string",
    },
    {
      name: "payments.amount",
      label: "Valor",
      editable: false,
      cell: "string",
      formatter: _.extend({}, Backgrid.CellFormatter.prototype, {
        fromRaw: function (rawValue, model) {
          return _(rawValue).currency();
        }
      })
    },
    {
      name: "payments.created_at",
      label: "Data execução",
      editable: false,
      cell: "string",
      cell: 'date'
    }
  ];

  // Initialize a new Grid instance
  var grid = new Backgrid.Grid({
    columns: columns,
    collection: contribuicoes,
    className: 'backgrid-striped backgrid'
  });

  var $box = $("#box-contribuicoes");
  // Render the grid and attach the root to your HTML document
  $box.append(grid.render().el);

  // Initialize the paginator
  var paginator = new Backgrid.Extension.Paginator({
    collection: contribuicoes
  });

  // Render the paginator
  $box.after(paginator.render().el);

  // Fetch some countries from the url
  contribuicoes.fetch({reset: true, success: function () {
    jQuery('#total_contribuicoes').html(paginator.collection.state.totalRecords);
  }});
}(jQuery, _));
