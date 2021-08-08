<?php declare(strict_types=1);

namespace Julien;

use Julien\GitOutputParser;

class Unpollute 
{
    public function __construct() {
        
    }


    // Returns array
    public static function get_checkout_candidates($str) {
            $split_git_output = preg_split ( '/\n{2}/' , $str );
            var_dump($split_git_output);
            // Changes not staged for commit AND Untracked files:
            foreach ($split_git_output as $i => $output_part) {
                    var_dump($output_part);
                    if ( str_starts_with($output_part , 'Changes not staged for commit:')) {
                            $lines = preg_split ( '/\n/' , $output_part );
                            $lines_array = [];
                            array_shift( $lines ); // remove first line
                            array_shift( $lines ); // remove second line
                            array_shift( $lines ); // remove third line
                            foreach ($lines as $line) {
                                    $lines_array []= ltrim(preg_split('/:/', ltrim($line), 2)[1]);
                            }
                            return $lines_array;
                    // } elseif ( str_starts_with($output_part, 'On branch master') ) {
                    //      $lines = preg_split ( '/\n/' , $output_part );
                    //      $lines_array = [];
                    //      array_shift( $lines ); // remove first line
                    //      array_shift( $lines ); // remove second line
                    //      array_shift( $lines ); // remove third line
                    //      array_shift( $lines ); // remove fourth line
                    //      foreach ($lines as $line) {
                    //              $lines_array []= ltrim(preg_split('/:/', ltrim($line), 2)[1]);
                    //      }
                    //      return $lines_array;
                    }
            }
            return false;
    }

        
    // Returns array
    function get_untracked_files($str) {
            $split_git_output = preg_split ( '/\n{2}/' , $str );

            // Changes not staged for commit AND Untracked files:
            foreach ($split_git_output as $output_part) {
                    if ( str_starts_with($output_part , 'Untracked files:') ) {
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
            return false;
    }

}
