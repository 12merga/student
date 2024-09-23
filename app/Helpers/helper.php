 <?php

    // app/Helpers/helper.php

    if (!function_exists('generateTeacherPassword')) {
        function generateTeacherPassword($firstName, $subject)
        {
            return strtolower($firstName) . ucfirst($subject); // e.g., johnMath
        }
    }
