<?php declare(strict_types=1);

namespace Julien;

class GitOutputParser 
{
    public function __construct() {
        
    }


    function string_starts_with( $haystack, $needle ) {
        return strpos( $haystack , $needle ) === 0;
    }

    // Returns array
    function get_checkout_candidates($str) {
        $str = trim($str);
        // Remove the first line if it's "On branch master" or something like that:
        $str = preg_replace('/^(On branch \w+)/', '', $str, 1);
        $str = trim($str);
        $split_git_output = preg_split('/\n{2}/' , $str );
        // var_dump($split_git_output);
        // Changes not staged for commit AND Untracked files:
        foreach ($split_git_output as $i => $output_part) {
                // var_dump($output_part);
                if ( self::string_starts_with($output_part , 'Changes not staged for commit:')) {
                        $lines = preg_split ( '/\n/' , $output_part );
                        $lines_array = [];
                        array_shift( $lines ); // remove first line
                        array_shift( $lines ); // remove second line
                        array_shift( $lines ); // remove third line
                        foreach ($lines as $line) {
                                $lines_array []= ltrim(preg_split('/:/', ltrim($line), 2)[1]);
                        }
                        return $lines_array;
                }
        }
        return [];
    }

        
    // Returns array
    function get_untracked_files($str) {
        $str = trim($str);
        // Remove the first line if it's "On branch master" or something like that:
        $str = preg_replace('/^(On branch \w+)/', '', $str, 1);
        $str = trim($str);

        $split_git_output = preg_split ( '/\n{2}/' , $str );

        // Changes not staged for commit AND Untracked files:
        foreach ($split_git_output as $output_part) {
                if ( self::string_starts_with($output_part , 'Untracked files:') ) {
                        $lines = preg_split ( '/\n/' , $output_part );
                        $lines_array = [];
                        array_shift( $lines ); // remove first line
                        array_shift( $lines ); // remove second line
                        foreach ($lines as $line) {
                                $lines_array []= ltrim($line);
                        }
                        return $lines_array;
                }
        }
        return [];
    }
    
}
