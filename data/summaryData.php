<?php

//headers for the csv file that will be created
$headers2 = array("Poster", "Rank", "Title", "Link"); 

//an array that holds all the data pertaining to the headers
//that will be used in the index.php page.
$summarizedData = array(

array("Poster"=> '<img src= "images/ShawShankRedemptionCover.jpg"
width=75px alt="icon" />', "Rank"=> "1", "Title"=> "The Shawshank Redemption",
"Link"=>'<form method ="POST" action="details/details.php?proid=1">
<button type="submit" name="shawShank" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=>'<img src= "images/TheGodFatherCover.jpg"
width=75px alt="icon" />', "Rank"=> "2", "Title"=> "The GodFather",
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="godFather" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=> '<img src= "images/TheGodFather2Cover.jpg"
width=75px alt="icon" />', "Rank"=> "3", "Title"=> "The GodFather: Part II", 
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="godFather2" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=> '<img src= "images/TheDarkKnightCover.jpg"
width=75px alt="icon" />', "Rank"=> "4", "Title"=> "The Dark Knight", 
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="darkKnight" class="btn btn-dark">Details</button>
</form>'), 

array( "Poster"=> '<img src= "images/12AngryMenPoster.jpg"
width=75px alt="icon" />', "Rank"=> "5", "Title"=> "12 Angry Men", 
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="12AngryMen" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=> '<img src= "images/SchindlersListCover.jpg"
width=75px alt="icon" />', "Rank"=> "6", "Title"=> "Schindlers List",  
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="schindlersList" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=> '<img src= "images/TheLordOfTheRingsCover.jpg"
width=75px alt="icon" />', "Rank"=> "7", "Title"=> "The Lord of the 
Rings: The Return of the King",
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="returnKing" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=> '<img src= "images/PulpFictionCover.jpg" 
width=75px alt="icon" />',"Rank"=> "8", "Title"=> "Pulp Fiction",
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="pulpFiction" class="btn btn-dark">Details</button>
</form>'), 

array("Poster"=> '<img src= "images/TheGoodTheBadCover.jpg"
width=75px alt="icon" />', "Rank"=> "9", "Title"=> "The Good, The Bad 
and The Ugly", "Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="theGoodTheBad" class="btn btn-dark">Details</button>
</form>'),

array("Poster"=> '<img src= "images/FellowShipCover.jpg"
width=75px alt="icon" />', "Rank"=> "10", "Title"=> "The 
Lord of The Rings: The Fellowship of the Ring", 
"Link"=>'<form method ="POST" action="details/details.php">
<button type="submit" name="fellowShip" class="btn btn-dark">Details</button>
</form>')

);
?>