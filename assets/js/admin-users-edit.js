$(document).ready(function(){
  $slider = $('#voteCostSlider');
  $sliderText = $('#voteCostText');

  $slider.on('change', function() {
    $sliderText.text($slider.val() + "X");
  });
});