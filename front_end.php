<?php
define("DEBUG", true);
define("SERIAL", false);


ini_set("display_errors", 1);
error_reporting(-1);

include_once "objects.php";

include_once "php_serial.class.php";

$crawl = "";
if (SERIAL)
{
     $serial=new phpSerial();
        $serial->deviceSet("COM2");
      $serial->deviceOpen();
}

$output = new output();
if (DEBUG)
{
//    $clackamas = new source("clackamas.htm");
  $washington = new source("washington.htm");
      $multnomah = new source("multnomah.htm");
    $sos = new source("sos.htm");
//    $WA = new source("http://vote.wa.gov/results/current/export/MediaResults.txt");
    
}
else
{
//     $clackamas = new source("http://www.clackamas.us/elections/results.jsp");
   $washington = new source("http://www.co.washington.or.us/AssessmentTaxation/Elections/CurrentElection/current-election-results.cfm");
     $multnomah = new source("http://web.multco.us/elections/may-15-2012-primary-election-election-results");
    //$sos = new source("http://www.sos.state.or.us/elections/results/2012S/index.html");
//    $WA = new source("http://vote.wa.gov/results/current/export/MediaResults.txt");
}

/*
$washington->useRAW = TRUE;


$race_temp = new race($sos);
$race_temp->choices[] = new choice("Dominic Hammon", "/Dominic Hammon\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Suzanne Bonamici", "/Suzanne Bonamici\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Brad Witt", "/Brad Witt\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Saba Ahmed", "/Saba Ahmed\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Brad Avakian", "/Brad Avakian\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Dan Strite", "/Dan Strite\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Robert Lettin", "/Robert E Lettin\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Todd Lee Ritter", "/Todd Lee Ritter\s+([0-9,]+)/");
$race_temp->slug = "AT-1CD-DEM";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "First Congressional District (Democrat)");
$crawl .= $crawl_temp->output() . "\r\n";

$races[]=$race_temp;
//echo "<pre>".$race_temp->source_ref->ToString(). "</pre>";


$race_temp = new race($sos);
$race_temp->choices[] = new choice("Lisa Michaels", "/Lisa Michaels\s+([0-9,]+)/");
$race_temp->choices[] = new choice("D R Delgado-Morgan", "/D R Delgado-Morgan\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Pavel Goberman", "/Pavel Goberman\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Jim Greenfield", "/Jim Greenfield\s+([0-9,]+)/");
$race_temp->choices[] = new choice("Rob Cornilles", "/Rob Cornilles\s+([0-9,]+)/");
$race_temp->slug = "AT-1CD-GOP";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "First Congressional District (Republican)");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;



$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/34-193 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/34-193 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Beav-Levy-W";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Beaverton Schools Levy");
$races[]=$race_temp;
*/

//1. PRESIDENT 

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Rick Santorum" , "/Rick Santorum.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Ron Paul",  "/Ron Paul.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Newt Gingrich",  "/Newt Gingrich.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Mitt Romney",  "/Mitt Romney.+?([0-9,]+)/");
$race_temp->slug = "AT1-President-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "United States President GOP");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Rick Santorum" , "/Rick Santorum.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Ron Paul",  "/Ron Paul.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Newt Gingrich",  "/Newt Gingrich.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Mitt Romney",  "/Mitt Romney.+?([0-9,]+)/");
$race_temp->slug = "AT1-President-W";
$race_temp->parse();
$crawl_temp->combine($race_temp);
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

//AG 5/14 extend the class - SOS
$sos_race_temp = new regexRace($sos, '[^0-9,]+([0-9,]+)');
$sos_race_temp->newCandidate("Rick Santorum");
$sos_race_temp->newCandidate("Ron Paul");
$sos_race_temp->newCandidate("Newt Gingrich");
$sos_race_temp->newCandidate("Mitt Romney");
$sos_race_temp->slug = "AT1-President-S";
$sos_race_temp->parse();
$sos_crawl_temp = new crawl($sos_race_temp, "Representative in Congress, 1st District GOP");
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

//2. Congress 1st
$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Lisa Michaels" , "/Lisa Michaels.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Delinda Morgan",  "/Delinda Morgan.+?([0-9,]+)/");
$race_temp->slug = "AT1-US-REP-1-GOP-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Representative in Congress, 1st District GOP");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Lisa Michaels" , "/Lisa Michaels.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Delinda Morgan",  "/Delinda Morgan.+?([0-9,]+)/");
$race_temp->slug = "AT1-US-REP-1-GOP-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

//AG -- good use of language ###Ref1
$_sos = new regexRace($sos, '[^0-9,]+([0-9,]+)');

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Lisa Michaels");
$sos_race_temp->newCandidate("Delinda Morgan");
$sos_race_temp->slug = "AT1-US-REP-1-GOP-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

//US Representative 3rd GOP
$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Ronald Green" , "/Ronald Green.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Delia Lopez",  "/Delia Lopez.+?([0-9,]+)/");
$race_temp->slug = "AT1-US-REP-3-GOP-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Representative in Congress, 3rd District GOP");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

//###Ref1
$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Ronald Green");
$sos_race_temp->newCandidate("Delia Lopez");
$sos_race_temp->slug = "AT1-US-REP-3-GOP-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Fred Thompson" , "/Fred Thompson.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Karen Bowerman",  "/Karen Bowerman.+?([0-9,]+)/");
$race_temp->slug = "AT1-US-REP-5-GOP-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Representative in Congress, 5th District GOP");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Fred Thompson");
$sos_race_temp->newCandidate("Karen Bowerman");
$sos_race_temp->slug = "AT1-US-REP-5-GOP-S";
$sos_race_temp->parse();

//$crawl_temp->combine($race_temp);
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;




$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Chris Telfer");
$sos_race_temp->newCandidate("Tim Knopp");
$sos_race_temp->slug = "AT1-US-SEN-27-GOP-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Senator, 27th District GOP");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Maryl Graybeal Featherstone");
$sos_race_temp->newCandidate("Bill Hansell");
$sos_race_temp->slug = "AT1-US-SEN-29-GOP-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Senator, 29th District GOP");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Kelly Lovelace");
$sos_race_temp->newCandidate("Jacob Daniels");
$sos_race_temp->slug = "AT1-US-Rep-11-GOP-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "House of Representatives, 11th District GOP");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Tom M Chereck Jr");
$sos_race_temp->newCandidate("Kathy LeCompte");
$sos_race_temp->slug = "AT1-US-REP-22-GOP-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "House of Representatives, 22nd District GOP");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Sam Cantrell" , "/Sam Cantrell.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Timothy E McMenamin",  "/Timothy E McMenamin.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-41-GOP-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 41st District GOP");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Sam Cantrel");
$sos_race_temp->newCandidate("Timothy E McMenamin");
$sos_race_temp->slug = "AT1-US-REP-41-GOP-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Daniel Ticknor" , "/Daniel Ticknor.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Michael Harrington",  "/Michael Harrington.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-44-GOP-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 44th Distric GOP");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Daniel Ticknor");
$sos_race_temp->newCandidate("Michael Harrington");
$sos_race_temp->slug = "AT1-US-REP-44-GOP-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;



$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Eli Stephens");
$sos_race_temp->newCandidate("Brent H Smith");
$sos_race_temp->newCandidate("Bob Jenson");
$sos_race_temp->newCandidate("Jack L Esp");
$sos_race_temp->slug = "AT1-US-REP-58-GOP-S";
$sos_race_temp->parse();
$crawl .= $crawl_temp->output() . "\r\n";
$crawl_temp = new crawl($race_temp, "State Representative, 58th District GOP");
$races[]=$sos_race_temp;





///////******************Democrats**********************\\\\\\\\\\\\\\\\

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("John Sweeney");
$sos_race_temp->newCandidate("Joyce B Segers");
$sos_race_temp->slug = "AT1-US-REP-2-DEM-S";
$sos_race_temp->parse();
$crawl .= $crawl_temp->output() . "\r\n";
$crawl_temp = new crawl($race_temp, "US Representative, 2nd District DEM");
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Peter A DeFazio");
$sos_race_temp->newCandidate("Matthew L Robinson");
$sos_race_temp->slug = "AT1-US-REP-4-DEM-S";
$sos_race_temp->parse();
$crawl .= $crawl_temp->output() . "\r\n";
$crawl_temp = new crawl($race_temp, "US Representative, 4th District DEM");
$races[]=$sos_race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Kate Brown" , "/Kate Brown.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Paul Damian Wells",  "/Paul Damian Wells.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-SOS-DEM-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Secretary of State DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$race_temp = new race($washington);
$race_temp->choices[] = new choice("Kate Brown" , "/Kate Brown.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Paul Damian Wells",  "/Paul Damian Wells.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-SOS-DEM-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;



$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Kate Brown");
$sos_race_temp->newCandidate("Paul Damian Wells");
$sos_race_temp->slug = "AT1-OR-SOS-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Dwight Holton" , "/Dwight Holton.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Ellen Rosenblum",  "/Ellen Rosenblum.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-AG-DEM-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Attorney General DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Dwight Holton" , "/Dwight Holton.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Ellen Rosenblum",  "/Ellen Rosenblum.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-AG-DEM-W";
$race_temp->parse();
$crawl_temp->combine($race_temp);
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Dwight Holton");
$sos_race_temp->newCandidate("Ellen Rosenblum");
$sos_race_temp->slug = "AT1-OR-AG-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;





$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Ben Unger" , "/Ben Unger.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Katie Riley" , "/Katie Riley.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-29-DEM-W";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 36th District DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Ben Unger");
$sos_race_temp->newCandidate("Katie Riley");
$sos_race_temp->slug = "AT1-OR-REP-29-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;





$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Sharon Meieran" , "/Sharon Meieran.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Benjamin J. Barber" , "/Benjamin Jay Barber.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jennifer Williamson",  "/Jennifer Williamson.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-36-DEM-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 36th District DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Sharon Meieran");
$sos_race_temp->newCandidate("Benjamin Jay Barber");
$sos_race_temp->newCandidate("Jennifer Williamson");
$sos_race_temp->slug = "AT1-OR-REP-36-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Thuy Tran" , "/Thuy Tran.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jessica V. Pederson" , "/Jessica Vega Pederson.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Andrew Haynes",  "/Andrew Haynes.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-47-DEM-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 47th District DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Thuy Tran");
$sos_race_temp->newCandidate("Jessica Vega Pederson");
$sos_race_temp->newCandidate("Andrew Haynes");
$sos_race_temp->slug = "AT1-OR-REP-47-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Mike Schaufler" , "/Mike Schaufler.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jeff Reardon" , "/Jeff Reardon.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-48-DEM-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 48th District DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Mike Schaufler");
$sos_race_temp->newCandidate("Jeff Reardon");
$sos_race_temp->slug = "AT1-OR-REP-48-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Peter Nordbye" , "/Peter Nordbye.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Marv Hollingsworth" , "/Marv Hollingsworth.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-REP-52-DEM-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "State Representative, 52nd District DEM");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Peter Nordbye");
$sos_race_temp->newCandidate("Marv Hollingsworth");
$sos_race_temp->slug = "AT1-OR-REP-52-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;



$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Timothy J. Sercombe" , "/Timothy J Sercombe.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Nena Cook" , "/Nena Cook.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Richard C. Baldwin",  "/Richard C Baldwin.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-Court-3-IND-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Judge of the Supreme Court, Position 3");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Timothy J. Sercombe" , "/Timothy J Sercombe.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Nena Cook" , "/Nena Cook.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Richard C. Baldwin",  "/Richard C Baldwin.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-Court-3-IND-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Timothy J Sercombe");
$sos_race_temp->newCandidate("Nena Cook");
$sos_race_temp->newCandidate("Richard C Baldwin");
$sos_race_temp->slug = "AT1-OR-REP-47-DEM-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;





//////////////////////////////////////////////////////////////////////////////////////////////10:30PM


$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Tim Volpert" , "/Tim Volpert.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Allan J. Arlow" , "/Allan J Arlow.+?([0-9,]+)/");
$race_temp->choices[] = new choice("James C. Egan",  "/James C Egan.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-Court-6-IND-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Judge of the Supreme Court, Position 6 ");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Tim Volpert");
$sos_race_temp->newCandidate("Allan J Arlow");
$sos_race_temp->newCandidate("James C Egan");
$sos_race_temp->slug = "AT1-OR-Court-6-S";
$sos_race_temp->parse();
$crawl_temp->fight_to_the_death($sos_race_temp);
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;
////////////////////////************SOS EXCLUSIVE*******\\\\\\\\\\\\\




$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Channing Bennett");
$sos_race_temp->newCandidate("Donald D Abar");
$sos_race_temp->slug = "AT1-Judge-3-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "Circuit Court Judge, 3rd District Position 11");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Wm Bruce Shepley");
$sos_race_temp->newCandidate("Mike Wetzel");
$sos_race_temp->slug = "AT1-Judge-5-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "Circuit Court Judge, 5th District Position 3");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Thomas M Spear Jr");
$sos_race_temp->newCandidate("Beth Bagley");
$sos_race_temp->newCandidate("Andrew C Balyeat");
$sos_race_temp->newCandidate("Aaron Brenneman");
$sos_race_temp->slug = "AT1-Judge-11-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "Circuit Court Judge, 11th District Position 2");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Stan Butterfield");
$sos_race_temp->newCandidate("Sally Avera");
$sos_race_temp->slug = "AT1-Judge-12-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "Circuit Court Judge, 12th District Position 1");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Pat Wolke");
$sos_race_temp->newCandidate("Victory D Walker");
$sos_race_temp->slug = "AT1-Judge-14-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "Circuit Court Judge, 14th District Position 2");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("John T Sewell");
$sos_race_temp->newCandidate("Brian Aaron");
$sos_race_temp->slug = "AT1-DA-H-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "District Attorney Hood River");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;

$sos_race_temp = clone $_sos;
$sos_race_temp->newCandidate("Aaron Felton");
$sos_race_temp->newCandidate("Jenn Gaddis");
$sos_race_temp->slug = "AT1-DA-P-S";
$sos_race_temp->parse();
$crawl_temp = new crawl($race_temp, "District Attorney Polk County");
$crawl .=$crawl_temp->output() . "\r\n";
$races[]=$sos_race_temp;










///////////*************END of SOS****************\\\\\\\\\\\\\\\\\\\
$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Wes Soderback" , "/Wes Soderback.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Deborah Kafoury" , "/Deborah Kafoury.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-Comis-1-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "County Commissioner Dist #1");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Judy Shiprack" , "/Judy Shiprack.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Patty Burkett" , "/Patty Burkett.+?([0-9,]+)/");
$race_temp->slug = "AT1-OR-Comis-3-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "County Commissioner Dist #3");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Steve Sung" , "/Steve Sung.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jefferson Smith" , "/Jefferson Smith.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Scott Fernandez" , "/Scott Fernandez.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Dave Campbell" , "/Dave Campbell.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Robert James Carron" , "/Robert James Carron.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Max Bauske" , "/Max Bauske.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Samuel Belisle" , "/Samuel Belisle.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Max Brumm" , "/Max Brumm.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Loren Charles Brown" , "/Loren Charles Brown.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Eileen Brady" , "/Eileen Brady.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Shonda Colleen Kelley" , "/Shonda Colleen Kelley.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Josh Nuttall" , "/Josh Nuttall.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Blake Nieman-Davis" , "/Blake Nieman-Davis.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Lew Humble" , "/Lew Humble.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Charlie Hales" , "/Charlie Hales.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Michael P Langley" , "/Michael P Langley.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Cameron Whitten" , "/Cameron Whitten.+?([0-9,]+)/");
$race_temp->choices[] = new choice("David Ackerman" , "/David (The Ack) Ackerman.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Tre Arrow" , "/Tre Arrow.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Bill Dant" , "/Bill Dant.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Howie Rubin" , "/Howie Rubin.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Christopher Rich" , "/Christopher Rich.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Scott Rose" , "/Scott Rose.+?([0-9,]+)/");
$race_temp->slug = "AT1-Port-Mayor-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Mayor City of Portland");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Steve Sung" , "/Steve Sung.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jefferson Smith" , "/Jefferson Smith.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Scott Fernandez" , "/Scott Fernandez.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Dave Campbell" , "/Dave Campbell.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Robert James Carron" , "/Robert James Carron.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Max Bauske" , "/Max Bauske.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Samuel Belisle" , "/Samuel Belisle.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Max Brumm" , "/Max Brumm.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Loren Charles Brown" , "/Loren Charles Brown.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Eileen Brady" , "/Eileen Brady.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Shonda Colleen Kelley" , "/Shonda Colleen Kelley.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Josh Nuttall" , "/Josh Nuttall.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Blake Nieman-Davis" , "/Blake Nieman-Davis.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Lew Humble" , "/Lew Humble.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Charlie Hales" , "/Charlie Hales.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Michael P Langley" , "/Michael P Langley.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Cameron Whitten" , "/Cameron Whitten.+?([0-9,]+)/");
$race_temp->choices[] = new choice("David Ackerman" , "/David (The Ack) Ackerman.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Tre Arrow" , "/Tre Arrow.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Bill Dant" , "/Bill Dant.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Howie Rubin" , "/Howie Rubin.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Christopher Rich" , "/Christopher Rich.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Scott Rose" , "/Scott Rose.+?([0-9,]+)/");
$race_temp->slug = "AT1-Port-Mayor-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Amanda Fritz" , "/Amanda Fritz.+?([0-9,]+)/");
$race_temp->choices[] = new choice("David G Gwyther" , "/David G Gwyther.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Mary Nolan" , "/Mary Nolan.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Bruce Altizer" , "/Bruce Altizer.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Teressa L Raiford" , "/Teressa L Raiford.+?([0-9,]+)/");
$race_temp->slug = "AT1-Port-Commis-1-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Commissioner, Pos. 1 CITY OF PORTLAND");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Amanda Fritz" , "/Amanda Fritz.+?([0-9,]+)/");
$race_temp->choices[] = new choice("David G Gwyther" , "/David G Gwyther.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Mary Nolan" , "/Mary Nolan.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Bruce Altizer" , "/Bruce Altizer.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Teressa L Raiford" , "/Teressa L Raiford.+?([0-9,]+)/");
$race_temp->slug = "AT1-Port-Commis-1-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Scott McAlpine" , "/Scott McAlpine.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Brian Sidney Parrott" , "/Brian Sidney Parrott.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Steve Novick" , "/Steve Novick.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Mark White" , "/Mark White.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jeri Williams" , "/Jeri Williams.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Leah Marie Dumas" , "/Leah Marie Dumas.+?([0-9,]+)/");
$race_temp->choices[] = new choice("James Rowell" , "/James Rowell.+?([0-9,]+)/");
$race_temp->slug = "AT1-Port-Commis-4-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Commissioner, Pos. 4 CITY OF PORTLAND");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Scott McAlpine" , "/Scott McAlpine.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Brian Sidney Parrott" , "/Brian Sidney Parrott.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Steve Novick" , "/Steve Novick.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Mark White" , "/Mark White.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jeri Williams" , "/Jeri Williams.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Leah Marie Dumas" , "/Leah Marie Dumas.+?([0-9,]+)/");
$race_temp->choices[] = new choice("James Rowell" , "/James Rowell.+?([0-9,]+)/");
$race_temp->slug = "AT1-Port-Commis-4-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Bob Stacey" , "/Bob Stacey.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Jonathan P Levine" , "/Jonathan P Levine.+?([0-9,]+)/");
$race_temp->slug = "AT1-Metro-6-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Metro Councilor, 6th District");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Sam Chase" , "/Sam Chase.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Terry Parker" , "/Terry Parker.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Brad Perkins" , "/Brad Perkins.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Helen Ying" , "/Helen Ying.+?([0-9,]+)/");
$race_temp->choices[] = new choice("Michael W. Durrow" , "/Michael (micro) W Durrow.+?([0-9,]+)/");
$race_temp->slug = "AT1-Metro-5-W";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Metro Councilor, 5th District");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-125 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-125 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-125-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-125 MULTNOMAH COUNTY LIBRARY");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-126 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-126 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-126-M";
$race_temp->parse();
//$crawl_temp = new crawl($race_temp, "26-126 TORT NOTICE");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-126 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-126 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-126-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-127 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-127 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-127-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-127 MAYORS FUND");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-127 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-127 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-127-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-128 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-128 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-128-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-128 OBSCENITY");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-128 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-128 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-128-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-129 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-129 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-129-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-129 VAGRANTS");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-129 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-129 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-129-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-130 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-130 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-130-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-130 BEGGING");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-130 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-130 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-130-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-131 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-131 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-131-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-131 EMERGENCY FUND");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-131 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-131 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-131-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-132 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-132 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-132-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-132 ELECTION PROCEDURES");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-132 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-132 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-132-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-133 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-133 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-133-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-133 HOUSEKEEPING");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-133 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-133 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-133-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-134 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-134 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-134-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-134 EXPOSITION RECREATION");
//$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/26-134 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-134 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-134-W";
$race_temp->parse();
$crawl_temp->Combine($race_temp);
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-135 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-135 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-135-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-135 DAVID DOUGLAS SCHOOL DISTRICT #40");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-136 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-136 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-136-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-136 GRESHAM NON-PARTISAN");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-137 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-137 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-137-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-137 GRESHAM COUNCILORS");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-138 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-138 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-138-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-138 GRESHAM MAYORAL ELECTION");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-139 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-139 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-139-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-139 GRESHAM COUNCIL QUALIFICATIONS");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Yes", "/26-140 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/26-140 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-140-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "26-140 GRESHAM COUNCIL VACANCIES");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;


$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/34-195 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/34-195 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-195-W";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "34-195 HILLSBORO POLICE FIRE PARKS");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/34-196 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/34-196 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-196-W";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "34-196 FOREST GROVE PUBLIC SAFETY");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;

$race_temp = new race($washington);
$race_temp->choices[] = new choice("Yes", "/34-197 .+\n.+Vote.+\n.+?([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/34-197 .+\n.+Vote.+\n.+\n.+?([0-9,]+)/");
$race_temp->slug = "AT-Measure-197-W";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "34-197 BANKS SCHOOLS");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;





/*
$race_temp = new race($multnomah);
$race_temp->choices[] = new choice("Suzanne Bonamici" , "/Suzanne Bonamici .+?([0-9,]+)/");
$race_temp->choices[] = new choice("Rob Cornilles",  "/Rob Cornilles .+?([0-9,]+)/");
$race_temp->choices[] = new choice("James Foster, Lib",  "/James Foster .+?([0-9,]+)/");
$race_temp->choices[] = new choice("Steven Reynolds, Prg",  "/Steven Reynolds .+?([0-9,]+)/");
$race_temp->slug = "AT1-First-Congress-M";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "First Congressional District 1");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;
*/

/*

$race_temp = new race($sos);  //TODO: SOS
$race_temp->choices[] = new choice("Suzanne Bonamici" , "/Suzanne\s+?Bonamici[.\s]+?([0-9,]+)/");
$race_temp->choices[] = new choice("Rob Cornilles",  "/Rob\s+?Cornilles[.\s]+?([0-9,]+)/");
$race_temp->choices[] = new choice("James Foster, Lib",  "/James\s+?Foster[.\s]+?([0-9,]+)/");
$race_temp->choices[] = new choice("Steven Reynolds, Prg",  "/Steven\s+?Reynolds[.\s]+?([0-9,]+)/");
$race_temp->slug = "AT1-First-Congress-SOS";
$race_temp->parse();
if (1)  //some condition to validate SOS's numbers
{
$crawl_temp = new crawl($race_temp, "First Congressional District 1");
$crawl = $crawl_temp->output() . "\r\n";
}
$races[]=$race_temp;

*/
/*
$race_temp = new race($clackamas);
$race_temp->choices[] =  new choice("Yes", "/Top 3-378.+?Yes ([0-9,]+)/");
$race_temp->choices[] = new choice("No", "/Top 3-378.+?No ([0-9,]+)/");
$race_temp->slug = "AT-3-378";
//$race_temp->parse();
$race_temp->choices[0]->value = 56541;
$race_temp->choices[1]->value = 18351;
$crawl_temp = new crawl($race_temp, "3-378   Renewal of Current County Sheriff Public Safety Local Option Levy");
$crawl .= $crawl_temp->output() . "\r\n";
$races[]=$race_temp;





$race_temp = new race($WA);
$race_temp->choices[] = new choice("Yes" , "/105190\tYes\t([0-9,]+)/");
$race_temp->choices[] = new choice("No",  "/105191\tNo\t([0-9,]+)/");
$race_temp->slug = "AT-1183";
$race_temp->parse();
$crawl_temp = new crawl($race_temp, "Initiative Measure 1183 Concerning liquor: beer, wine, and spirits (hard liquor)");
$crawl .= $crawl_temp->output() . "\r\n";

$races[]=$race_temp;





*/
foreach ($races as $race)
{
//echo "{$race->slug} Yes: {$race->yes()}  No: {$race->no()}<br>";
$output->Add($race);

}
$output->Finalize();

echo "<PRE>" . $output->out . "</pre>";

echo $crawl;

$graphic = fopen("2011 Election.txt", "w");
fwrite($graphic, $crawl);

if(    DEBUG )
{
       $serial->sendMessage($output->out);
     $serial->sendMessage("\r\n\r\n");
     $serial->deviceClose();
       echo "<script language='javascript'>setTimeout(\"window.location='live.php'\", 15000);</script>";
}
else
{
       $serial->sendMessage($output->out);
     $serial->sendMessage("\r\n\r\n");
     $serial->deviceClose();
       echo "<script language='javascript'>setTimeout(\"window.location='live.php'\", 15000);</script>";
     
}



?>