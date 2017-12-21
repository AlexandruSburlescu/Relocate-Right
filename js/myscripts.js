$( document ).ready(function() {
    if ("message" in sessionStorage) $('#front-page').hide();
    if ("responsive" in sessionStorage)  $("#lreel").css('display','none');
    if ("about" in sessionStorage)  $("#lreel").css('display','none');
    else {
        $( "#front-page-button" ).click(function() {
            $('#front-page').siblings().show();
            $('#front-page').parents().siblings().show();
            $('#front-page').slideUp("slow");
            sessionStorage.setItem("message",true);
        });
    }
    $( "#logout-button" ).click(function() {
        sessionStorage.removeItem("message");
        sessionStorage.removeItem("responsive");
    });

$( "#register-button" ).click(function() {
       var email = $("#email").val();
       var password = $("#password").val();
       $("#login-form").css('display','none');
       $("#register-form").css('display','block');
       $("#register-email").val(email);
       $("#register-password").val(password);
       $("#session_message").text('Please register below to view our listings:');
  });

$( "#login-button" ).click(function() {
         if ($(window).width() < 768 )
         {
             sessionStorage.setItem("responsive",true);
         }
    });

$( "#about-button" ).click(function() {
        if ($(window).width() < 768 )
        {
            sessionStorage.setItem("about",true);
        }
    });

$( "#home-button" ).click(function() {
    if ($(window).width() < 768 )
    {
        sessionStorage.removeItem("about");
    }
});

});


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
