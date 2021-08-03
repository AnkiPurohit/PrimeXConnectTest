<?php
/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

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

    
    /**
     * @OA\Property(
     *      title="Token",
     *      description="Token of the user",
     *      example="11|nfksfasklmasdsasdasdsadas"
     * )
     *
     * @var string
     */
    public $token;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

}