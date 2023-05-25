<?php

    class FetchUsersTest extends \PHPUnit\Framework\TestCase {
        public function testUsers() {
            // test with fetching users from db
            $this->expectNotToPerformAssertions();
            $users = new Users\Users();
            $users->chooseCorrectMethod();
        }
    }

?>