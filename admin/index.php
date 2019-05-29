<?php require_once './template/header.php'; ?>
   <?php $page = isset($_GET['p']) ? addslashes($_GET['p']) : false; ?>
      <section class="">
         <div class="container">
            <div class="row">
               <div  class="col-md-3">
                  <nav>
                     <ul class="list-group">
                        <a href="<?php echo URL_ADMIN;?>" class="list-group-item <?php echo $page==false ? "list-group-item-primary": "";?>">Home</a>
                        <a href="<?php echo URL_ADMIN."index.php?p=categorias"?>" class="list-group-item <?php echo $page=="categorias" ? "list-group-item-primary": ""; ?>">Categorias</a>
                        <a href="<?php echo URL_ADMIN."index.php?p=subcategorias"?>" class="list-group-item <?php echo $page=="subcategorias" ? "list-group-item-primary": ""; ?>">Subcategorias</a>
                        <a href="<?php echo URL_ADMIN."index.php?p=produtos"?>" class="list-group-item <?php echo $page=="produtos" ? "list-group-item-primary": ""; ?>">Produtos</a>
                        <a href="<?php echo URL_ADMIN."index.php?p=capitulos"?>" class="list-group-item <?php echo $page=="capitulos" ? "list-group-item-primary": ""; ?>">Capítulo</a>
                        <a href="<?php echo URL_ADMIN."index.php?p=aulas"?>" class="list-group-item <?php echo $page=="aulas" ? "list-group-item-primary": ""; ?>">Aulas</a>
                     </ul>
                  </nav>
               </div>

               <div class="col-md-9">
                  <article>
                     <?php 
                        
                        
                        if(!empty($page)) {
                           $page = $page.".php";
                           if(file_exists($page)) {
                              require_once $page;
                           }
                        } else {                           
                           require_once 'home.php';
                        }
                     ?>
                  </article>                  
               </div>
            </div>
         </div>
         <div class="row">
            <div class="container">

            </div>
         </div>
      </section>

<?php require_once './template/footer.php'; ?>