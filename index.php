<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>
<body>
    
    <div class="calculator">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="number" step="any" name="num01" placeholder="Number one or base" required>
            <select name="operator">
                <option value="add">+</option>
                <option value="subtract">-</option>
                <option value="multiply">*</option>
                <option value="divide">/</option>
                <option value="power">pow</option>
            </select>
            <input type="number" step="any" name="num02" placeholder="Number two or exponent" required>
            <button>Calculate</button>
        </form>

        <div class="result-container">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Grab data from inputs
                    $num01 = filter_input(INPUT_POST, "num01", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $num02 = filter_input(INPUT_POST, "num02", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $operator = htmlspecialchars($_POST["operator"]);

                    // Error handlers
                    $errors = false;

                    // Check all the fields are filled in
                    if(!isset($num01) || !isset($num02) || !isset($operator)) {
                        echo "<p class='calc-error'>Fill in all fields!</p>";
                        $errors = true;
                    }

                    // Check for numbers
                    if (!is_numeric($num01) || !is_numeric($num02)) {
                        echo "<p class='calc-error'>Only write numbers!</p>";
                        $errors = true;
                    }

                    // Check for division by zero
                    if ($operator == "divide" && $num02 == 0) {
                        echo "<p class='calc-error'>Error: Cannot divide by zero!</p>";
                        $errors = true;
                    }

                    // Calculate the numbers if no errors
                    if (!$errors) {
                        $value = 0;
                        switch($operator) {
                            case "add":
                                $value = $num01 + $num02;
                                break;
                            case "subtract":
                                $value = $num01 - $num02;
                                break;
                            case "multiply":
                                $value = $num01 * $num02;
                                break;
                            case "divide":
                                $value = $num01 / $num02;
                                break;
                            case "power":
                                $value = $num01 ** $num02;
                                break;
                            default:
                                echo "<p class='calc-error'>Something went horribly wrong!</p>";
                        }

                        echo "<p class='calc-result'>Result = " . $value . "</p>";
                    }
                }
            ?>
        </div>
    </div>

</body>
</html>