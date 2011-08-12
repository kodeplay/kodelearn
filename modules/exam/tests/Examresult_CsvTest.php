<?php defined('SYSPATH') OR die('No direct access allowed.');

class Examresult_CsvTest extends Kohana_UnitTest_TestCase {

    public function test_matrix() {
        $students = array(
            2 => 'Vineet Naik',
            3 => 'Jimit Modi',
            4 => 'Dharmesh Dhakan',
            20 => 'Axansh Sheth',
        );
        $exams = array(
            3 => 'Discrete Maths Monthly test',
            6 => 'Simple Php test',
        );
        $results = array_fill_keys(array_keys($students), array_fill_keys(array_keys($exams), '-'));
        $results[2][3] = 0;
        $results[3][3] = 12;
        $results[4][6] = 15;
        $results[20][6] = 24;
        $matrix = Examresult_Csv::matrix($students, $exams, $results);
        $expected = array(
            array('Student Id', 'Student Name', 'Discrete Maths Monthly test', 'Simple Php test'),
            array(2, 'Vineet Naik', 0, '-'),
            array(3, 'Jimit Modi', 12, '-'),
            array(4, 'Dharmesh Dhakan', '-', 15),
            array(20, 'Axansh Sheth', '-', 24)
        );
        $this->assertEquals($expected, $matrix);
    }
}