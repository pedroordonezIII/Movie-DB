<?php

//create the headers for the csv page.  
$headers = array("Title", "Rank", "Star Rating", "Poster", "Rating", 
"Release Date", "Runtime", "Category", "Genre", "Summary"); 

//array data that pertains to the headers above for each chosen movie
$detailedData = array(

    array("Title"=> "The Shawshank Redemption", "Rank"=> "1", 
    "Star Rating"=> "9.2", "Poster"=> '<img src= "../images/ShawShankRedemptionCover.jpg"
    width=225px alt="icon" />', "Rating"=> "R", "Release Date"=> "14 October 1994",
    "Runtime"=> "2h 22min", "Category"=> "Top Rated", "Genre"=> "Drama", 
    "Summary"=> "Two imprisoned men bond over a number of years, finding solace 
    and eventual redemption through acts of common decency."), 

    array("Title"=> "The GodFather", "Rank"=> "2", 
    "Star Rating"=> "9.1", "Poster"=> '<img src= "../images/TheGodFatherCover.jpg"
    width=225px alt="icon" />', "Rating"=> "R", "Release Date"=> "24 March 1972",
    "Runtime"=> "2h 55min", "Category"=> "Top Rated", "Genre"=> "Crime", 
    "Summary"=> "An organized crime dynasty's aging patriarch transfers 
    control of his clandestine empire to his reluctant son."), 

    array("Title"=> "The GodFather: Part II", "Rank"=> "3", 
    "Star Rating"=> "9.0", "Poster"=> '<img src= "../images/TheGodFather2Cover.jpg"
    width=225px alt="icon" />', "Rating"=> "R", "Release Date"=> "18 December 1974",
    "Runtime"=> "3h 22min", "Category"=> "Top Rated", "Genre"=> "Crime", 
    "Summary"=> "The early life and career of Vito Corleone in 1920s New York City is 
    portrayed, while his son, Michael, expands and tightens his grip on the family crime 
    syndicate."), 

    array("Title"=> "The Dark Knight", "Rank"=> "4", 
    "Star Rating"=> "9.0", "Poster"=> '<img src= "../images/TheDarkKnightPoster.jpg"
    width=225px alt="icon" />', "Rating"=> "PG-13", "Release Date"=> "18 July 2008",
    "Runtime"=> "2h 32min", "Category"=> "Top Rated", "Genre"=> "Action", 
    "Summary"=> "When the menace known as the Joker wreaks havoc and chaos on
    the people of Gotham, Batman must accept one of the greatest psychological 
    and physical tests of his ability to fight injustice."), 

    array("Title"=> "12 Angry Men", "Rank"=> "5", 
    "Star Rating"=> "8.9", "Poster"=> '<img src= "../images/12AngryMenPoster.jpg"
    width=225px alt="icon" />', "Rating"=> "Approved", "Release Date"=> "4 February 1994",
    "Runtime"=> "1h 36m", "Category"=> "Top Rated", "Genre"=> "Crime", 
    "Summary"=> "A jury holdout attempts to prevent a miscarriage of justice by
     forcing his colleagues to reconsider the evidence."), 

    array("Title"=> "Schindlers List", "Rank"=> "6", 
    "Star Rating"=> "8.9", "Poster"=> '<img src= "../images/SchindlersListCover.jpg"
    width=225px alt="icon" />', "Rating"=> "R", "Release Date"=> "14 October 1994",
    "Runtime"=> "3h 15m", "Category"=> "Top Rated", "Genre"=> "Biography", 
    "Summary"=> "In German-occupied Poland during World War II, industrialist 
    Oskar Schindler gradually becomes concerned for his Jewish workforce after
     witnessing their persecution by the Nazis."), 

    array("Title"=> "The Lord of the Rings: The Return of the King", "Rank"=> "7", 
    "Star Rating"=> "8.9", "Poster"=> '<img src= "../images/TheLordOfTheRingsCover.jpg"
    width=225px alt="icon" />', "Rating"=> "R", "Release Date"=> "17 December 2003",
    "Runtime"=> "3h 21m", "Category"=> "Top Rated", "Genre"=> "Action", 
    "Summary"=> "Gandalf and Aragorn lead the World of Men against Sauron's army 
    to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring."), 


    array("Title"=> "Pulp Fiction", "Rank"=> "8", "Star Rating"=> "8.8", 
    "Poster"=> '<img src= "../images/PulpFictionCover.jpg" width=225px alt="icon" />',
    "Rating"=> "R", "Release Date"=> "14 October 1994","Runtime"=> "2h 34m", 
    "Category"=> "Top Rated", "Genre"=> "Crime", "Summary"=> "The lives of two mob
     hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine
     in four tales of violence and redemption."), 

    array("Title"=> "The Good, The Bad and The Ugly", "Rank"=> "9", 
    "Star Rating"=> "8.8", "Poster"=> '<img src= "../images/TheGoodTheBadCover.jpg"
    width=225px alt="icon" />', "Rating"=> "R", "Release Date"=> "29 December 1967",
    "Runtime"=> "2h 58m", "Category"=> "Top Rated", "Genre"=>"Western", 
    "Summary"=> "A bounty hunting scam joins two men in an uneasy alliance 
    against a third in a race to find a fortune in gold buried in a remote cemetery."), 

    array("Title"=> "The Lord of The Rings: The Fellowship of the Ring", "Rank"=> "10", 
    "Star Rating"=> "8.8", "Poster"=> '<img src= "../images/FellowShipCover.jpg"
    width=225px alt="icon" />', "Rating"=> "PG-13", "Release Date"=> "19 December 2001",
    "Runtime"=> "2h 58min", "Category"=> "Top Rated", "Genre"=> "Action", 
    "Summary"=> "A meek Hobbit from the Shire and eight companions set out on a 
    journey to destroy the powerful One Ring and save Middle-earth from the 
    Dark Lord Sauron.")

); 


?>