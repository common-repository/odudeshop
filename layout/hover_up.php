<?php
$output_top='
<style>


.image-frame {
  position: relative;
  width: 190px;
  height: 230px;
  margin: 10px;
  cursor: pointer;
  overflow: hidden;
  text-align: center;
  float: left;
  background: #eee;
}

.image-frame .img {
  margin-top: 10px;
  height: 125px;
  background: #eee;
  width: 120px;
  margin: 10px auto;
}

.image-frame h2 {
  font-size: 14px;
  height: 30px;
}

.image-frame p {
	background: rgba(192, 192, 192, .5);
  font-size: 18px;
  font-weight: 700;
  margin: 0;
}

.image-frame p.only {

  position: absolute;
  left: 40px;
  font-size: 10px;
  bottom: 10px
}

.image-frame .image-hover {
  width: 190px;
  height: 250px;
  background: rgba(255, 255, 255, 0.9);
  position: absolute;
  bottom: -250px;
  opacity: 0;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: alpha(opacity=0);
  -moz-opacity: 0;
  -khtml-opacity: 0;
  color: #ffffff;
  transition: bottom 0.4s, opacity 0.4s;
  -webkit-transition: bottom 0.4s, opacity .2s;
}

.image-frame:hover .image-hover {
  bottom: 0px;
  opacity: 1;
  opacity: 1;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
  filter: alpha(opacity=90);
  -moz-opacity: 1;
  -khtml-opacity: 1;
  transition: bottom 0.4s, opacity 0.4s;
  -webkit-transition: bottom 0.4s linear, opacity 0.4s;
}

.read-more {
  color: #FFF;
  text-decoration: none;
  background: #8D171A;
  padding: 10px 20px;
  margin: 100px auto 0px auto;
  transition: background 0.4s;
  -webkit-transition: background 0.4s;
  text-transform: uppercase;
  display: block;
  width: 100px;
}

.read-more:hover {
  background: #333;
  transition: background 0.4s;
  -webkit-transition: background 0.4s;
}
</style>
';
$output_top.='<div class="pure-g">';
return $output_top;
?>
