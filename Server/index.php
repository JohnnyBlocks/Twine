<!DOCTYPE HTML>
<title>Twine Log</title>
<html>


<style>
	body {
		font-family: Verdana;
	}

	.TableContainer {
		display: table;
	}

	.TableRow  {
		display: table-row;
	}

	.TableCell {
		display: table-cell;
	}

	.RowHeader {
		border-bottom: 1px solid black;
		font-weight: bold;
	}

	.RowTime {
		width: 200px;
	}

	.RowString {
		width: 400px;
	}

	#TwineIP {
		width: 180px;
		font-size: 14pt;
	}

</style>



<body>

<?php
    include_once("_analytics.php");
    include_once("_database.php");

    # You can use this example to send the temperature as a GET request:  http://twinelog.yoyo.pete.com?TEMP=[temperature]
    
    # The IF checks if there is a post variable to decide if it's a twine GET request.
    # This logic could be removed to it's own page instead of looking for GET variables in the URL.
    # I simply insert a record into a database, but you could use $_GET["TEMP"] to reference the TEMP variable and take whatever action.
    if (count($_GET) != 0) {
        $link = mysqli_connect($server,$username,$password,$database,3306);
        $query = "Insert Into TwineLog (TwineKey,Request,EventTime) values ('".$_SERVER[REMOTE_ADDR]."','".$_SERVER[QUERY_STRING]."',NOW())";
        $result = mysqli_query($link, $query);
        mysqli_close($link);
        
    # If there's no GET it means it's viewed by a browser.
    } else {
        print "<h2>Welcome to <a href='http://twine.supermechanical.com' target='_blank'>Twine</a> Log</h2>";
        print "<a href='#instructions'>Instructions</a> - <a href='https://github.com/YoYo-Pete/TwineLog' taqrget='_blank'>Source Code<a/> <br /><br />";
		
        # Connects to my MySQL database to get log records that were inserted above.
        $link = mysqli_connect($server,$username,$password,$database,3306);
        if (!$link) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        $query = "SELECT * from TwineLog order by EventTime Desc";
        $result = mysqli_query($link, $query);
        
        print "<div class='TableContainer'>";
            print "<div class='TableRow RowHeader'>";
                print "<div class='RowHeader TableCell RowTime'>Date Time</div>";
                print "<div class='RowHeader TableCell RowString'>Request String</div>";
            print "</div>";
        print "</div>";
        
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            print "<div class='TableRow'>";
                print "<div class='RowTime TableCell'>".$row["EventTime"]."</div>";
                print "<div class='RowHeade TableCell RowString'>".$row["Request"]."</div>";
            print "</div>";
        }
        mysqli_free_result($result);
        mysqli_close($link);
        
        print "Note: Time's are in GMT (I think) <br /><br />";

        print "<a id='instructions'></a><h4>How to set up your TWINE with this TWINE LOG</h4>";
        print "1.  Log into your twine's web console.  <a href='https://twine.supermechanical.com/' target='_blank'>https://twine.supermechanical.com/</a> <br />";
        print "2.  Click on the 'Rules >' button to view your rules.<br />";
        print "3.  On an existing rule, click 'Add an Action' and select 'HTTP Request'. <br />";
        print "4.  Enter the following into the field for URL to log the temperature. <br />";
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><e>http://twinelog.yoyo.pete.com?t=[temperature]</e></strong> <br />";
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style='color:darkred;'>YOU MUST HAVE A URL VARIABLE FOR THIS TO WORK.</strong> <br />";
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>It can be anything: http://twinelog.yoyo.pete.com?test=anything </strong> <br />";
        print "5.  Click the 'Test URL' button. <br />";
        print "6.  Refresh this page to see your results. <br /><br />";
        print "<br />";
        print "Note: Your twine results are mixed into this list.  Use something specific in your URL string. <br />";
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><e>http://twinelog.yoyo.pete.com?t=[temperature].YourName</e></strong> <br />";
        print "<br />";
        print "Note: Twine will only pass the first URL variable. <br />";
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://twinelog.yoyo.pete.com/t=[temperature]&o=[orientation] <br />";
        print "The above example will only record 't=78' as the request string instead of 't=78&amp;o=top' <br />";
        print "This is an issue with Twine's servers as only the first variable is sent in the request string.";
        

       
    }
    
?>

</body>
</html>


