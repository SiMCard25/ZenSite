<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns+"http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $pagetitle; ?></title>
    <style type="text/css">
    	<!--
    		@import "./Footy/CSS/Footy.css";
    	-->
    	</style>

<script src="./src/prototype.js" type="text/javascript"></script>
<script src="./src/scriptaculous.js" type="text/javascript"></script>
<script src="./src/AHAHStuff.js" type="text/javascript"></script>

<script>
<!--
function land(ref, target) {
  lowtarget=target.toLowerCase();
  if (lowtarget=="_self") {window.location=loc;}
  else {if (lowtarget=="_top") {top.location=loc;}
  else {if (lowtarget=="_blank") {window.open(loc);}
  else {if (lowtarget=="_parent") {parent.location=loc;}
  else {parent.frames[target].location=loc;};
  }}}
}

function jump(menu) {
  ref=menu.choice.options[menu.choice.selectedIndex].value;
  splitc=ref.lastIndexOf("*");
  target="";
  if (splitc!=-1) {
    loc=ref.substring(0,splitc);
    target=ref.substring(splitc+1,1000);
  }
  else {loc=ref; target="_self";};
  if (ref != "") {land(loc,target);}
}
//-->

</script>

</head>
