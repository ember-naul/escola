<?php
        die('<!doctype html>
    <html lang="en">
    
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Erro ao entrar</title>
      <link href="table.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    
    <body>
      <div class="modal" tabindex="-1" id="erroModal"> <!-- Adicionado ID para referenciar o modal -->
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Erro!, você não está logado</h5>
            </div>
            <div class="modal-body">
              <p>Você não tem permissão para entrar nesta página. Você precisa ter permissão para acessar essa pagina.</p>
            </div>
            <div class="modal-footer">
              <a href="../logout.php"><button type="button" class="btn btn-success">Logout</button></a>
            </div>
          </div>
        </div>
      </div>
    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script>
        // Script para mostrar o modal automaticamente ao carregar a página
        window.onload = function() {
          var modal = new bootstrap.Modal(document.getElementById(\'erroModal\'));
          modal.show();
        };

        
      </script>
    </body>
    
    </html>');
    
 ?>