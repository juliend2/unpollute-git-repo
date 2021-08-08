<?php declare(strict_types=1);

namespace Julien\Tests;

use PHPUnit\Framework\TestCase;
use Julien\GitOutputParser;

final class GitOutputParserTest extends TestCase
{


    public function testCheckoutCandidatesInChangesAndUntrackedFilesContext(): void
    {
        $test_output = <<<TXT
On branch master
Your branch is up to date with 'origin/master'.

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   readme.html
        modified:   wp-config-sample.php

Untracked files:
  (use "git add <file>..." to include in what will be committed)
        testfile.txt
        testfolder/

no changes added to commit (use "git add" and/or "git commit -a")
TXT;
        $test_output = trim($test_output);

        $this->assertEquals(
            2,
            count(GitOutputParser::get_checkout_candidates($test_output))
        );
    }

    public function testCheckoutCandidatesInChangesOnly(): void 
    {
        $test_output = <<<TXT
On branch master
Changes not staged for commit:
  (use "git add/rm <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   bat/ReCaptcha/RequestMethod/Post.php
        modified:   bat/reCaptcha.php
        deleted:    index.html

no changes added to commit (use "git add" and/or "git commit -a")
TXT;
        $test_output = trim($test_output);

        $this->assertEquals(
            3,
            count(GitOutputParser::get_checkout_candidates($test_output))
        );
    }
}
