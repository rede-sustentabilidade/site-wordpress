//main.js contents
//Pass a config object to require
require.config({
  baseUrl: '/wp-content/themes/rede-sustentabilidade/assets/',
    modules: ["Minuta", "Filiacao", "Site"]
});

// require(["cart", "store", "store/util"],
// function (cart,   store,   util) {
//     //use the modules as usual.
// });
