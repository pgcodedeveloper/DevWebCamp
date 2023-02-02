<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige tu Plan</p>


    <div class="paquetes__grid">
        <div data-aos="<?php aos_animacion(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio">$0</p>

            <form action="/finalizar-registro/gratis" method="POST">
                <input type="submit" value="Inscripción Gratis" class="paquetes__submit">
            </form>
        </div>

        <div data-aos="<?php aos_animacion(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase Presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Presencial a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Acceso a Talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
                <li class="paquete__elemento">Camisa del Evento</li>
                <li class="paquete__elemento">Comida y Bebida</li>
            </ul>

            <p class="paquete__precio">$200</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div data-aos="<?php aos_animacion(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase Virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Enlace a Talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
            </ul>

            <p class="paquete__precio">$50</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-virtual"></div>
                </div>
            </div>
        </div>
    </div>
</main>



<script src="https://www.paypal.com/sdk/js?client-id=AcjPa6hdClH38ZkmuVeBv2iPXiE383GCadbfMBapDv8zu8pMN6p8tp2juSqd_G_ZzgPpBlPYATEuLnR8&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
        paypal.Buttons({
        style: {
            shape: 'pill',
            color: 'blue',
            layout: 'vertical',
            label: 'pay',
            
        },

        createOrder: function(data, actions) {
            return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":200}}]
            });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                const datos = new FormData();
                datos.append('paquete_id',orderData.purchase_units[0].description);
                datos.append('pago_id',orderData.purchase_units[0].payments.captures[0].id);

                const url= `${window.location.origin}/finalizar-registro/pagar`
                fetch(url,{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(resultado => {
                    if(resultado.resultado){
                        actions.redirect(`${window.location.origin}/finalizar-registro/conferencias`);
                    }
                })
            });

            
        },

        onError: function(err) {
            console.log(err);
        }
        }).render('#paypal-button-container');

        //Pase Virtual
        paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"2","amount":{"currency_code":"USD","value":50}}]
          });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                const datos = new FormData();
                datos.append('paquete_id',orderData.purchase_units[0].description);
                datos.append('pago_id',orderData.purchase_units[0].payments.captures[0].id);

                const url= `${window.location.origin}/finalizar-registro/pagar`
                fetch(url,{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(resultado => {
                    if(resultado.resultado){
                        actions.redirect(`${window.location.origin}/finalizar-registro/conferencias`);
                    }
                })
            });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container-virtual');
    }
    initPayPalButton();
</script>