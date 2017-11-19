function myMap() {
    var latlng = new google.maps.LatLng(51.5115123,-0.0990959);
    map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 12
    });
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: 'Relocate Right'
    });
}

var index = 1;
slideShow(index);

function nextSlide(i) {
    slideShow(index += i);
}

function slideShow(i) {
    var j;
    var slides = document.getElementsByClassName("gallery");

    if (i > slides.length) {index = 1}
    if (i < 1) {index = slides.length}
    for (j = 0; j < slides.length; j++) {
        slides[j].style.display = "none";
    }
    slides[index-1].style.display = "block";

}
