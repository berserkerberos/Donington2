   <!-- Logout Modal-->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Atención!</h5>
           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
           </button>
         </div>
         <div class="modal-body">Confirma salir del sistema.</div>
         <div class="modal-footer">
           <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
           <a class="btn btn-primary" href="{{asset('/cerrarSession')}}">Si</a>
         </div>
       </div>
     </div>
   </div>

   <div class="modal fade" id="modalGeneral" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">
             <div id="temp_titulo">
             </div>
           </h5>
           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
           </button>
         </div>
         <div class="modal-body">
           <div id="temp_cuerpo">
           </div>
         </div>
         <div class="modal-footer">
           <button class="btn btn-info" id="btnModGenAceptar" type="button" data-dismiss="modal">Aceptar</button>
           <button class="btn btn-danger" id="btnModGenCancelar" type="button" data-dismiss="modal">Cancelar</button>
         </div>
       </div>
     </div>
   </div>

   <div class="modal fade" id="modalIframe" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content" style="min-height: 600px;">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">
             <div id="ifrmTitulo">

             </div>
           </h5>
           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
           </button>
         </div>
         <div class="modal-body">
           <h2 id="frmCargando" class="text-center" >Cargando ... <i class="far fa-clock"></i></h2>
           <iframe src="" id="modalIfr" frameborder="0" style="width: 100%;min-height: 500px;">

           </iframe>
         </div>
       </div>
     </div>
   </div>

   <script>
     function modalGeneral(titulo, msg, fun_si, fun_no, reemplazarCuerpo) {
       $("#temp_titulo").html(titulo)
       if (reemplazarCuerpo) {
         $("#temp_cuerpo").html(msg)
       }
       $("#btnModGenAceptar").off("click")
       $("#btnModGenCancelar").off("click")
       $("#btnModGenAceptar").on("click", fun_si)
       $("#btnModGenCancelar").on("click", fun_no)
       $("#modalGeneral").modal()
       return $(this)
     };

     function modalIfm(titulo, url) {
       $("#frmCargando").show();
       $("#ifrmTitulo").html(titulo)
       $("#ifrmTitulo")
       $("#modalIfr").hide();
       $("#modalIfr").attr("src", url)
       $("#modalIfr").on("load",function(){
        $("#frmCargando").hide("slow");
        $("#modalIfr").show("slow");
       })
       $("#modalIframe").modal()
       return $(this)
     };
   </script>