(function(){
  if(document.querySelector('#smart-button-container')){
      function initPayPalButton() {
          paypal.Buttons({
            style: {
              shape: 'rect',
              color: 'blue',
              layout: 'vertical',
              label: 'paypal',

            },

            createOrder: function(data, actions) {
              return actions.order.create({
                purchase_units: [{"description":"Pago presencial DevWebCamp", "amount":{"currency_code":"USD","value":199}}]
              });
            },

            onApprove: function(data, actions) {
              //or  derData es toda la inforamacino que nos da paypal del pago
              return actions.order.capture().then(function(orderData) {

                // Full available details
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                // Show a success message within this page, e.g.
                // const element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';

                // Or go to another URL:  actions.redirect('thank_you.html');

                //HACEMOS EL FETCH A NUESTRO SERVIDOR
                const datos = new FormData();
                datos.append('paquete_id', 1);
                datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id );
                // console.log(orderData.purchase_units[0].payments.captures[0].id);

                fetch('/finalizar-registro/pagar', {
                  method: 'POST',
                  body: datos
                })
                .then(respuesta => respuesta.json())
                .then(resultado => {
                  // console.log(resultado);
                  if(resultado.resultado)
                  actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
                })
              });
            },

            onError: function(err) {
              console.log(err);
            }
          }).render('#paypal-button-container');
      }
      initPayPalButton();
  }
})();