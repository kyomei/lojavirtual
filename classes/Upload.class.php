<?php

/**
 * Description of ImagesUpload
 *
 * @author Rafael Jeferson <rafa.jefer@gmail.com>
 * @tutorial package
 */

class Upload {


    public static function images($fotos, $produto_id, $dir = null)
    {
        // Se foi passado um diretório, seta ele na variavel $dir
        if($dir != null) {
            $pasta = $dir;
            $dir = '../../../assets/imagens/'.$dir;
        
            // Se não existir diretório crie
            if(!is_dir($dir))
                mkdir($dir, 0777, $recursive = true);
        } else {
            $dir = '../../../assets/imagens';
        }       

        // Verifica se foi enviada alguma imagem
        if(count($fotos) > 0) {
            
            echo "<script>alert(' count ok')</script>";
            // percorre as imagens enviadas
            for($q=0;$q<count($fotos['tmp_name']);$q++) {
                // Cria um array para guarda os tipos das imagens
                $tipo = $fotos['type'][$q];
                // Verifica se extensao das imagens são jpeg ou png
                if(in_array($tipo, array('image/jpeg', 'image/png'))) {
                    // Cria um nome aleatório para imagem e define sua extensão jpg
                    $tmpname = md5(time().rand(0,9999)).'.jpg';
                    // Move a imagem para a pasta indicada
                    //$path = 'assets/imagens/'.$dir.'/'.$tmpname;
                    $path = $dir.'/'.$tmpname;
                    move_uploaded_file($fotos['tmp_name'][$q], $path);

                    // Guarda as dimensoes da imagem nas variaveis da list
                    list($width_orig, $height_orig) = getimagesize($path);
                    $ratio = $width_orig/$height_orig;

                    // Tamanho máximo das imagens
                    $width = 500;
                    $height = 500;

                    // Verifica se imagem enviada é maior que tamanho máximo
                    if($width/$height > $ratio) {
                        $width = $height*$ratio;
                    } else {
                        $height = $width/$ratio;
                    }

                    // Cria imagem
                    $img = imagecreatetruecolor($width, $height);

                    // Verifica se o tipo é jpeg
                    if($tipo == 'image/jpeg') {
                        // Cria imagem jpeg
                        $origi = imagecreatefromjpeg($path);
                    } elseif($tipo == 'image/png') {
                        // Cria imagem png
                        $origi = imagecreatefrompng($path);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagejpeg($img, $path, 80);

                    isset($pasta) ? $tmpname = $pasta.'/'.$tmpname : '';
                    $sql = "INSERT INTO produto_imagens SET produto_id = :produto_id, url = :url";
                    $stmt = Conexao::prepare($sql);
                    $stmt->bindValue(':produto_id', $produto_id);
                    $stmt->bindValue(':url', "assets/imagens/".$tmpname);
                    $stmt->execute();
                }
            }
        }
    }
}