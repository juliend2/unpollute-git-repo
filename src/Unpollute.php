<?php declare(strict_types=1);

namespace Julien;

use Julien\GitOutputParser;

class Unpollute 
{

    private $repo_path;
    private $git_bin;

    public function __construct($repo_path, $git_bin) {
        $this->path = $repo_path;
        $this->git = $git_bin;
    }

    private function execute_command( $cmd ) {
        ob_start();
        system($cmd, $status_code) ;
        $out = ob_get_contents();
        ob_end_clean();
        return [$out, $status_code];
    }

    private function fix_git_index_and_exit($path) {
        echo "whooops";
        system("cd $path && rm -f ./.git/index.lock");
        exit(1); // problem
    }

    public function execute() {
        $git_status = self::execute_command( "cd $this->path && $this->git status" );
        $git_status_output = $git_status[0];
        $git_status_code = $git_status[1]; // status code

        if ($git_status_code !== 0) {
                $this->fix_git_index_and_exit($this->path);
        }

        $to_checkout = GitOutputParser::get_checkout_candidates($git_status_output);
        $to_remove = GitOutputParser::get_untracked_files($git_status_output);

        foreach ($to_checkout as $f) {
                system("cd $this->path && $this->git checkout ".escapeshellarg($f), $git_status_code);
                if ($git_status_code !== 0) {
                        $this->fix_git_index_and_exit($this->path);
                }
        }

        foreach ($to_remove as $f) {
                system("cd $this->path && rm -rf ".escapeshellarg($f));
        }

    } 

}
