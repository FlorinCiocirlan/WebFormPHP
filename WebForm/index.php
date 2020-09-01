<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <form action="" method="post">
        <Label>Name</Label>
        <input type="text" name="name" required>
        <br/>
        <label>
            Year
            <select name="year" required>
                <?php
                    generateOptions(1900, 2020);
                ?>
            </select>
        </label>
        <label>
            Month
            <select name="month" required>
                <?php
                    generateMonthsOptions();
                ?>
            </select>
        </label>
        <label>
            Day
            <select name="day" required>
                <?php
                    generateOptions(1, 30);
                ?>
            </select>
        </label>
        <label>
            Gender
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </label>
        <br/>
        <fieldset name="hobby">
            <legend>Please select one or more hobbies</legend>
            <?php
                generateRadio();
            ?>
        </fieldset>
        <input type="submit" name="submit" value="Send">
    </form>
</div>
</body>
</html>

<?php

    function generateOptions($start, $end)
    {
        for ($i = $start; $i <= $end; $i++) {
            echo '<option value='.$i.'>'.strval($i).'</option>';
        }
    }

    function generateMonthsOptions()
    {
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            echo '<option value='.$month.'>'.strval($month).'</option>';
        }
    }

    function getHobbies()
    {
        return $hobbies = ['sports', 'reading', 'watching TV', 'programming', 'dancing'];
    }

    function generateRadio()
    {
        $hobbies = getHobbies();
        foreach ($hobbies as $hobby) {
            echo '<label>'.$hobby.'</label>'.'<input type="radio" name="'.$hobby.'" value="'.$hobby.'">';
        }
    }

    function displayName($name)
    {
        $namesArray = explode(' ', $name);
        if (count($namesArray) > 1) {
            echo '<p>'.'First Name: '.ucwords($namesArray[0]).'<br/>'.' Last Name: '.ucwords($namesArray[1]).'</p>';
        } else {
            echo '<p>'.'Name: '.ucwords($namesArray[0]).'</p>';
        }
    }

    function displayDate($date)
    {
        $in = '<p> Born on : ';
        $out = '</p>';
        $result = $in.$date[2].' '.$date[1].' '.$date[0].$out;
        echo $result;
    }

    function description($gender, $hobbies)
    {
        $gender === 'male' ? $isMan = true : $isMan = false;
        $isMan ? $content = '<p>His ' : $content = '<p>Her ';
        count($hobbies) > 1 ? $content.='hobbies are : ' : $content.='hobby is : ';
        foreach ($hobbies as $hobby) {
            if (strpos($hobby, '_')) {
                $content .= str_replace('_', ' ', $hobby).', ';
            } else {
                $content .= $hobby.', ';
            }
        }
        $content = rtrim($content,', ');
        $content .= '.</p>';
        echo $content;
    }

    function sanitizeHobbies($hobbies)
    {
        for ($i = 0; $i < count($hobbies); $i++) {
            if (str_word_count($hobbies[$i])) {
                $hobbies[$i] = str_replace(' ', '_', $hobbies[$i]);
            }
        }

        return $hobbies;
    }

    if (isset($_POST['submit'])) {
        $hobbies = sanitizeHobbies(getHobbies());
        $selectedHobbies = [];
        foreach ($hobbies as $hobby) {
            if (isset($_POST[$hobby])) {
                array_push($selectedHobbies, $hobby);
            }
        }
        displayName($_POST['name']);
        displayDate([$_POST['year'], $_POST['month'], $_POST['day']]);
        description($_POST['gender'], $selectedHobbies);
    }
?>

