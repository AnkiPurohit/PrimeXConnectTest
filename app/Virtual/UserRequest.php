<?php
/**
 * @OA\Schema(
 *      title="User request",
 *      description="User Request",
 *      type="object",
 *      required={"email","password"}
 * )
 */

class UserRequest
{
    
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of User",
     *      example="Jane"
     * )
     *
     * @var name
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email of the user",
     *      example="jane@doe.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the user",
     *      example="123456"
     * )
     *
     * @var string
     */
    public $password;


}