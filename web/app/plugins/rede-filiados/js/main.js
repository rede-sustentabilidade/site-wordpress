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
  target: "_self",

  initialize: function (options) {
    ActionCell.__super__.initialize.apply(this, arguments);
    this.title = options.title || this.title;
    this.target = options.target || this.target;
  },

  render: function () {
    this.$el.empty();
    var rawValue = this.model.get(this.column.get("name"));
    var formattedValue = this.formatter.fromRaw(rawValue, this.model);

    this.$el.append($("<a>", {
      tabIndex: -1,
      href: '?page=rs_contribuicoes&afiliados.user_id='+rawValue,
      title: this.title || formattedValue,
      target: this.target
    }).text('Ver Contribuições'));
    this.$el.append(' - ');
    this.$el.append($("<a>", {
      tabIndex: -1,
      href: '?page=rs_filiado_profile&user_id='+rawValue,
      title: this.title || formattedValue,
      target: this.target
    }).text('Editar'));
    this.delegateEvents();
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
      name: "user_id",
      label: "Ações",
      editable: false,
      cell: "action"
      // formatter: _.extend({}, Backgrid.CellFormatter.prototype, {
      //   fromRaw: function (rawValue, model) {
      //     return 'http://vair/'+rawValue;
      //   }
      // })
    },
    {
      name: "fullname",
      label: "Nome Completo",
      editable: false,
      cell: "string"
    },
    {
      name: "cpf",
      label: "CPF",
      editable: false,
      cell: "string",
    },
    {
      name: "email",
      label: "E-mail",
      editable: false,
      cell: "string",
    },
    {
      name: "telefone_residencial",
      label: "Telefone",
      editable: false,
      cell: "string",
    },
    {
      name: "telefone_celular",
      label: "Celular",
      editable: false,
      cell: "string",
    },
    {
      name: "telefone_comercial",
      label: "Comercial",
      editable: false,
      cell: "string",
    },
	{
      name: "sexo",
      label: "Sexo",
      editable: false,
      cell: "string",
    },
    {
      name: "status",
      label: "Status",
      editable: false,
      cell: "string",
    },
    {
      name: "uf",
      label: "UF",
      editable: false,
      cell: "string"
    },
    {
      name: "cidade",
      label: "Cidade",
      editable: false,
      cell: "string"
    },
    {
      name: "bairro",
      label: "Bairro",
      editable: false,
      cell: "string"
    },
    {
      name: "endereco",
      label: "Endereço",
      editable: false,
      cell: "string"
    },
    {
      name: "cep",
      label: "CEP",
      editable: false,
      cell: "string"
    },
    {
      name: "titulo_eleitoral",
      label: "Título Eleitoral",
      editable: false,
      cell: "string",
    },
    {
      name: "zona_eleitoral",
      label: "Zona Eleitoral",
      editable: false,
      cell: "string",
    },
    {
      name: "secao_eleitoral",
      label: "Seção Eleitoral",
      editable: false,
      cell: "string",
    },

    // {
    //   name: "payments.amount",
    //   label: "Valor",
    //   editable: false,
    //   cell: "string",
    //   formatter: _.extend({}, Backgrid.CellFormatter.prototype, {
    //     fromRaw: function (rawValue, model) {
    //       return _(rawValue).currency();
    //     }
    //   })
    // },
    {
      name: "created_at",
      label: "Data cadastro",
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
