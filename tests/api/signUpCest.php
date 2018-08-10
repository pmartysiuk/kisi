<?php


class signUpCest
{
    public function signInValidCredentials(ApiTester $I)
    {
        $I->wantToTest("Sign in with valid credentials");
        $json = '{"user":{"email":"pmartysiuk@gmail.com","password":"12345678"}}';
        $expectedJson = '{
            "id": 428580,
            "email": "pmartysiuk@gmail.com",
            "name": "Pavel Martysiuk",
            "image": null,
            "notifications_unread_count": 0,
            "otp_required_for_login": null,
            "otp_enabled_at": null,
            "has_primary_device": false,
            "primary_login_exists": false
        }';

        $params = json_decode($json, true);
        $expectedJson = json_decode($expectedJson, true);

        $I->haveHttpHeader("Accept", "application/json");
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPOST("/users/sign_in", $params);
        $I->canSeeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseContainsJson($expectedJson);
    }

    public function signInInvalidEmail(ApiTester $I)
    {
        $I->wantToTest("Sign in with wrong email");

        $json = '{"user":{"email":"pmartysiuk23@gmail.com","password":"12345678"}}';
        $expectedJson = '{"error":"Wrong email address or password.","code":"afc516","message":"Wrong email address or password.","reason":"Wrong email address or password."}';

        $params = json_decode($json, true);
        $expectedJson = json_decode($expectedJson, true);

        $I->haveHttpHeader("Accept", "application/json");
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPOST("/users/sign_in", $params);
        $I->canSeeResponseCodeIs(401);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseContainsJson($expectedJson);
    }

    public function signInWithNotActivatedAccount(ApiTester $I)
    {
        $I->wantToTest("Sign in with not activated email");

        $json = '{"user":{"email":"pmartysiuk2@gmail.com","password":"12345678"}}';
        $expectedJson = '{"error":"You have to confirm your email address before continuing.","message":"You have to confirm your email address before continuing.","reason":"You have to confirm your email address before continuing."}';

        $params = json_decode($json, true);
        $expectedJson = json_decode($expectedJson, true);

        $I->haveHttpHeader("Accept", "application/json");
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPOST("/users/sign_in", $params);
        $I->canSeeResponseCodeIs(401);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseContainsJson($expectedJson);
    }

    public function signInInvaliPassword(ApiTester $I)
    {
        $I->wantToTest("Sign in with wrong password");

        $json = '{"user":{"email":"pmartysiuk@gmail.com","password":"123456789"}}';
        $expectedJson = '{"error":"Invalid email address or password.","code":"afc506","message":"Invalid email address or password.","reason":"Invalid email address or password."}';

        $params = json_decode($json, true);
        $expectedJson = json_decode($expectedJson, true);

        $I->haveHttpHeader("Accept", "application/json");
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPOST("/users/sign_in", $params);
        $I->canSeeResponseCodeIs(401);
        $I->canSeeResponseIsJson();
        $I->canSeeResponseContainsJson($expectedJson);
    }
}
