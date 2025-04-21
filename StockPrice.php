
<?php
// Get the sending information (search text)
$searchText = $_GET["searchKey"];
$csvfile = "top10companies.csv";

// Read the CSV and search for a match with the search text
if (file_exists($csvfile) && $filestream = fopen($csvfile, "r")) {
    // Read the header row to determine column indexes
    $header = fgetcsv($filestream, 0, ",");
    $symbolIndex = array_search("Symbol", $header);
    $companyIndex = array_search("Company", $header);

    if ($symbolIndex === false || $companyIndex === false) {
        print("Invalid CSV format");
        exit;
    }

    // Boolean variable for a match
    $found = false;

    // Number of matches
    $nummatch = 0;

    // If more than 1 match, then store them in an array
    $matches = array();

    // Indexes of array $matches
    $i = 0; // Row

    // Loop through the $filestream
    while (($recordArray = fgetcsv($filestream, 0, ",")) !== false) {
        // Extract the relevant individual values only
        $symbol = $recordArray[$symbolIndex];
        $company = $recordArray[$companyIndex];

        if (stripos($company, $searchText) !== false || stripos($symbol, $searchText) !== false) {
            $found = true;
            $nummatch++;

            // Populate the array
            $matches[$i][0] = $symbol;
            $matches[$i][1] = $company;
            $i++;
        }
    } // End of while loop

    if ($found == false) {
        print("No match found");
    } else {
        if ($nummatch == 1) {
            $info = $matches[0][0] . "/" . $matches[0][1]; // Using '/' in case companies have a comma in their names
            print("onematch" . "/" . $info);
        } else {
            // Start sending the beginning of a select element
            print("<select id='companyList' onchange='getSymbol()'>");
            print("<option value=''>Select a Company</option>");

            // Loop through the match array and send the option to HTML
            foreach ($matches as $match) {
                $symbol = $match[0];
                $company = $match[1];
                $info = $symbol . "/" . $company;
                print("<option value='" . $info . "'>" . $company . "</option>");
            }

            // Send close select to HTML
            print("</select>");
        }
    }
} else {
    print("CSV file not available");
}
?>