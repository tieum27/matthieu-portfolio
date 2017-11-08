<!--

/*
Configure menu styles below
NOTE: To edit the link colors, go to the STYLE tags and edit the ssm2Items colors
*/
YOffset=150; // no quotes!!
XOffset=0;
staticYOffset=30; // no quotes!!
slideSpeed=20 // no quotes!!
waitTime=100; // no quotes!! this sets the time the menu stays out for after the mouse goes off it.
menuBGColor="#333399";
menuIsStatic="yes"; //this sets whether menu should stay static on the screen
menuWidth=150; // Must be a multiple of 10! no quotes!!
menuCols=2;
hdrFontFamily="verdana";
hdrFontSize="2";
hdrFontColor="white";
hdrBGColor="#333399";
hdrAlign="left";
hdrVAlign="center";
hdrHeight="15";
linkFontFamily="Verdana";
linkFontSize="1";
linkBGColor="white";
linkOverBGColor="#FFFF99";
linkTarget="_top";
linkAlign="Left";
barBGColor="#333399";
barFontFamily="Verdana";
barFontSize="3";
barFontColor="white";
barVAlign="center";
barWidth=20; // no quotes!!
barText="MENU"; // <IMG> tag supported. Put exact html for an image to show.

///////////////////////////

// ssmItems[...]=[name, link, target, colspan, endrow?] - leave 'link' and 'target' blank to make a header
//ssmItems[9]=["FAQ", "http://www.dynamicdrive.com/faqs.htm", "", 1, "no"] //create two column row

ssmItems[0]=["Le CNPA"] //create header
ssmItems[1]=["Les News", "divers/news.php", "matt"]
ssmItems[2]=["Historique du club et chartre qualite", "histo.html","matt"]
ssmItems[3]=["Niveaux de pratique", "divers/niveau.html", "matt"]

ssmItems[4]=["Stages et formation"] //create header
ssmItems[5]=["Voile<br>5-12 ans", "stages/voile1.html", "matt", 1, "no"]
ssmItems[6]=["Voile<br>11-15 ans", "stages/voile2.html", "matt", 1, "yes"]
ssmItems[7]=["Voile +16ans - Adultes", "stages/voile3.html", "matt",]
ssmItems[8]=["Char a voile", "stages/char.html", "matt"]
ssmItems[9]=["Natation", "stages/natation.html", "matt"]
ssmItems[10]=["Permis Mer Cotier", "permis.html", "matt"]

ssmItems[11]=["Club et ecole de sport"] //create header
ssmItems[12]=["Club", "sport/club.html", "matt"]
ssmItems[13]=["Ecole de sport", "sport/ecole.html", "matt"]

ssmItems[14]=["Autre option"] //create header
ssmItems[15]=["Point plage", "autre/point_plage.html", "matt"]
ssmItems[16]=["Accueil groupe", "autre/groupe", "matt"]
ssmItems[17]=["Info et inscription", "autre/info.html", "matt"]
ssmItems[18]=["Liens", "autre/liens.html", "matt"]

buildMenu();

//-->
