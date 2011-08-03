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
        $matrix = Examresult_Csv::matrix($students, $exams);
        $expected = array(
            array('Student Id', 'Student Name', 'Discrete Maths Monthly test', 'Simple Php test'),
            array(2, 'Vineet Naik', '', ''),
            array(3, 'Jimit Modi', '', ''),
            array(4, 'Dharmesh Dhakan', '', ''),
            array(20, 'Axansh Sheth', '', '')
        );
        $this->assertEquals($expected, $matrix);
    }
}