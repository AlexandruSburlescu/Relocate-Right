<?php
require '../users/database.php';
try{
    $sql1 = 'SELECT *
             FROM property_image
             LEFT JOIN images ON images.image_id = property_image.image_id
             LEFT JOIN properties ON properties.property_id = property_image.property_id 
             WHERE properties.type = "buy"';

    $rec = $connection->prepare($sql1);
    $rec->execute();
    $res = $rec->fetchAll(PDO::FETCH_ASSOC);
    $images = $res;

    $sql2 = 'SELECT *
             FROM properties
             WHERE properties.type = "buy"';

    $rec = $connection->prepare($sql2);
    $rec->execute();
    $res = $rec->fetchAll(PDO::FETCH_ASSOC);
    $properties = $res;
}

catch(Exception $e)
{
    die($e);
}

if (count($properties) == 0 ) {$_SESSION['message'] = 'There are no listings to display.';}

require '../header.php';
?>
<div class = "row">
<?php
require '../body/left-reel.php';
?>
<div class="col-6 container">
    <?php foreach ($properties as $property) {

        //find out the number of images needed to display in the thumbnails section
        $thumbnails =0 ;
        foreach($images as $image) {
            if ($image['property_id'] == $property['property_id'] && $image['main'] != '1') {
                $thumbnails++;
            }
        }
        ?>
        <div class = "row" id="<?=$property['property_id']?>">
            <div class= "gallery fade">
                <div class = "row">
                    <div class="galleryHead">Properties available for purchase</div>
                </div>
                <div class = "row">
                    <div class = "col-2" style ="float:left">
                        <a class="prev" onclick="nextSlide(-1)">&#10094;</a>
                    </div>
                    <div class ="col-8">
                        <?php

                        foreach($images as $image)  {
                            if($image['property_id'] == $property['property_id'] && $image['main'] == '1' ) { ?>
                                <img src="<?=$image['image_url']?>" style="width:100%">
                            <?php  } ?>
                        <?php  } ?>
                    </div>
                    <div class = "col-2" style = "float:right">
                        <a class="next" onclick="nextSlide(1)">&#10095;</a>
                    </div>
                </div>
                <div class = "row">
                    <?php
                    foreach($images as $image)  {
                        if($image['property_id'] == $property['property_id'] && $image['main'] != '1' ) { ?>

                            <a href ="<?=$image['image_url']?>">
                                <img src="<?=$image['image_url']?>" style="float:left;padding:10px;width:<?=100/$thumbnails?>%;max-height:<?=100/$thumbnails?>%">
                            </a>

                        <?php  } ?>
                    <?php  } ?>

                </div>
                <div class = "row">
                    <div class="galleryText"><?=$property['description']?></div>
                    <div class = "galleryText">Price: <?=$property['price']?>&pound
                        <?php if ($property['type' ]== 'rent') {echo 'PCM.'; } else {echo '.';} ?></div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
require '../body/right-reel.php';
?>
</div>
<?php
require '../footer.php';
?>


