<?php

$sql1 = 'SELECT property.* image.image_url FROM property LEFT JOIN image ON property.image_id = image.id WHERE property.star = 1';
$rec = $conn->prepare($sql1);
$rec->execute();
$res = $rec->fetchAll(PDO::FETCH_OBJ);
$properties = $res;

if (count($properties) == 0 ) {$_SESSION['message'] = 'Your star buildings database is empty. Please star at least one.';}

?>

<div class="col-6">
    <? foreach ($property as $properties) :?>
    <div class = "row" id="<?=$property->id?>">
        <div class= "gallery fade">
            <div class = "row">
                <div class="galleryHead">Our current listings</div>
            </div>
            <div class = "row">
                <div class = "col-2" style ="float:left">
                <a class="prev" onclick="nextSlide(-1)">&#10094;</a>
                </div>
                <div class ="col-8">
                <img src="<?=$property->image_url?>" style="width:100%">
                </div>
                <div class = "col-2" style = "float:right">
                <a class="next" onclick="nextSlide(1)">&#10095;</a>
                </div>
            </div>
            <div class = "row">
                <div class="galleryText">Caption Text</div>
            </div>
            <div class ="row">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                </div>
            </div>
        </div>
    </div>
    <? endforeach; ?>
</div>


