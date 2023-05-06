<?php

    class FetchUsersTest extends \PHPUnit\Framework\TestCase {
        public function testUsers() {
            $this->expectNotToPerformAssertions();
            $users = new Users\Users();
            $users->chooseCorrectMethod();
        }
    }

?>