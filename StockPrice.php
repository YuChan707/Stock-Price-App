<?php
    //read the csv and put together the select element and send it back to the HTML 
    $file = "distance_NY_worldcapitals_partial.csv";

    //ensuring the csv file exists and it can create an input stream out of it
    if (file_exists($file) && $fileStream = fopen($file, "r"))
    {
        //prepare to read the file
        //first skip the first two lines on the csv file
        $numreading = 1;

        //send back the start of the select element to the HTML page
        print("<select id='countryList' onchange='showdistance()'>");
        print("<option value=''>Select a Country</option>");

        //loop through the entire file stream
        while ( ($recordArray = fgetcsv($fileStream, 0, ",")) != FALSE   )
        {
            //skipping the first two records
            if ($numreading <= 2) $numreading++;
            else
            {
                //extract the components of the record we read
                $country = $recordArray[0];
                $capital = $recordArray[1];
                $miles = $recordArray[2];
                $km = $recordArray[3];

                //populate the select element with the option
                //but first let's put together the value of the option
                $optionValue = $country.",".$capital.",".$miles.",".$km;

                //now send the option to HTML
                print("<option value='" . $optionValue . "'>" . $country.", ". $capital. "</option>");
            }
        }//end of while loop

        //send back the close of select element
        print("</select>");
    }




?>