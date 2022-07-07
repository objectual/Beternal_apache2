@extends("frontend.layouts.layout")
@section("title","Success Schedule")
@section("content")
<style>
.mySlides {display:none}
.w3-left, .w3-right, .w3-badge {cursor:pointer}
.w3-badge {height:13px;width:13px;padding:0}
.w3-text-white, .w3-hover-text-white:hover {
    color: #fff!important;
}
.w3-section, .w3-code {
    margin-top: 16px!important;
    margin-bottom: 16px!important;
}
.w3-center {
    text-align: center!important;
}
.w3-large {
    font-size: 38px!important;
}
.w3-container, .w3-panel {
    padding: 0.01em 16px;
}

.w3-content, .w3-auto {
    margin-left: auto;
    margin-right: auto;
}

.w3-tooltip, .w3-display-container {
    position: relative;
}
.w3-display-bottommiddle {
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translate(-50%,0%);
    -ms-transform: translate(-50%,0%);
}
.w3-container:after, .w3-container:before, .w3-panel:after, .w3-panel:before, .w3-row:after, .w3-row:before, .w3-row-padding:after, .w3-row-padding:before, .w3-cell-row:before, .w3-cell-row:after, .w3-clear:after, .w3-clear:before, .w3-bar:before, .w3-bar:after {
    content: "";
    display: table;
    clear: both;
}
.w3-transparent, .w3-hover-none:hover {
    background-color: transparent!important;
}
.w3-border {
    border: 1px solid #ccc!important;
}
.w3-badge {
    border-radius: 50%;
}

.w3-badge, .w3-tag {
    background-color: #000;
    color: #fff;
    display: inline-block;
    padding-left: 5px;
    padding-right: 5px;
    text-align: center;
}

.w3-white, .w3-hover-white:hover {
    color: #000!important;
    background-color: #fff!important;
}

.w3-left {
    float: left!important;
}
.w3-right {
    float: right!important;
}
</style>
<div class="container-fluid success-bg">
    <div class="row pt-3">
        <div class="col-lg-8 offset-lg-2 text-center success-img-bg"> 

        <div class="w3-content mt-3 mb-3 w3-display-container">
        <img class="mySlides" src="https://www.w3schools.com/w3css/img_nature_wide.jpg" style="width:100%; display:block">
        <img class="mySlides" src="https://www.w3schools.com/w3css/img_snow_wide.jpg" style="width:100%">
        <img class="mySlides" src="https://www.w3schools.com/w3css/img_nature_wide.jpg" style="width:100%">
        <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
            <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)">&#10094;</div>
            <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)">&#10095;</div>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(1)"></span>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(2)"></span>
            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(3)"></span>
        </div>
        
        </div>
        </div>
    </div>
</div>
@endsection
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-white";
}
</script>