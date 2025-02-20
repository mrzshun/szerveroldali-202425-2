<?php

namespace App\Models;

class Post {

    public static function all() {
        return [
            [
                "id" => 94883,
                "title" => "Ut dolorem consequatur neque ea animi sit non consequatur.",
                "description" => "Odio earum illo maxime voluptatem dicta rerum. Quo et consequatur dolores dignissimos dolor unde ipsum id. Error repudiandae hic voluptate commodi laboriosam nihil delectus dolore.",
                "text" => "Aliquid non distinctio necessitatibus velit. Molestias ducimus et aut consequatur iure qui eius. Omnis voluptas enim minima hic reiciendis est velit.\n\nVero omnis quia vel dicta earum culpa iste. Blanditiis et molestiae dignissimos quaerat voluptatem provident. Animi corporis voluptatum et doloribus ipsa sed.\n\nRepellat ducimus dolorum minus quos totam in. Quibusdam soluta aut laudantium deserunt magni sunt ut occaecati.\n\nMaiores consequatur odio perspiciatis. Id ad sunt corporis. Quis aperiam laborum porro recusandae odio vel ut adipisci. Dicta possimus iure expedita aut voluptas.\n\nPariatur quis doloribus tenetur iure qui consequatur voluptatem. In error dicta iusto aspernatur quibusdam praesentium. Quis voluptate veritatis asperiores qui quam. Architecto et adipisci et et quia nam. Aut blanditiis aut est natus blanditiis.",
                "author" => "Prof. Kareem O'Keefe I"
            ],
            [
                "id" => 31056,
                "title" => "Quod recusandae architecto quis repellendus.",
                "description" => "Doloribus est natus vitae voluptas rerum deleniti nemo. Hic repudiandae ut est pariatur assumenda ipsum eos. Corrupti consequatur incidunt quis quia sed natus at consequatur.",
                "text" => "Consequatur id dolores quis et. Tempora iusto sunt aliquam aperiam voluptatem. Laudantium vel voluptatum eos praesentium.\n\nIure quo similique autem dolore. Tempora ea aut tenetur quo aut at. Earum et aliquid et. Est sapiente voluptatibus soluta repellat et.\n\nIllum laudantium aut quod ipsum aut ad. Magni eveniet eligendi maiores rem perferendis ut. Eum maiores dolor perspiciatis et exercitationem.\n\nUnde et illum laborum maiores velit eveniet. Velit asperiores pariatur rerum praesentium libero quae. Et dolores ea tempora tenetur debitis ab autem.\n\nQui voluptatem porro voluptate quia. Laudantium facere ut natus ut id omnis vel officiis. Aperiam esse incidunt et perspiciatis omnis cumque. Et delectus autem quia eos.",
                "author" => "Malcolm Heller"
            ],
            [
                "id" => 48428,
                "title" => "Et iusto eligendi impedit provident.",
                "description" => "Consequatur ut temporibus laudantium quae tenetur nam. Commodi rerum exercitationem aut in accusamus. Repudiandae aspernatur illum incidunt qui.",
                "text" => "Nulla distinctio aperiam qui recusandae eveniet sunt. Minus voluptatem et et at voluptatem iste. Laborum quam alias illum atque dolorem.\n\nEnim id non iste doloribus. Illo dolores neque excepturi enim et laudantium.\n\nQuis eveniet voluptas aliquid rerum et enim corporis. Vel sequi blanditiis libero aliquam alias magnam. Sit est facere beatae et. Sed quas quae dolores sint explicabo.\n\nAut laudantium harum quia accusantium. Saepe animi placeat explicabo saepe ipsum animi.\n\nEt vero autem deserunt incidunt. Quos et saepe rerum odio ea ut. Et ab velit molestiae aspernatur cupiditate et tempore. Consequuntur quisquam harum deserunt.",
                "author" => "Miss Gerda Christiansen II"
            ],
            [
                "id" => 45702,
                "title" => "Et adipisci aliquam repudiandae cum voluptatem rerum eum.",
                "description" => "Quaerat quibusdam voluptates assumenda voluptas magni accusantium. Est nisi cumque voluptas voluptatibus ipsum itaque neque. Animi aut voluptatum repellendus pariatur.",
                "text" => "Aliquid distinctio qui consequuntur omnis maxime quisquam sunt. Et aut enim cupiditate et quia magni rerum. Rerum temporibus voluptatum libero ut eum exercitationem.\n\nPossimus quis officia natus et. Et vero ex possimus voluptatibus ipsa. Adipisci adipisci voluptate at quia. Rerum aut possimus hic quasi laudantium sit modi ut.\n\nDolores aut fugit quae dolor veritatis dolores. Nemo velit est dolor. Et non quia sunt in corrupti beatae. Consequatur sequi debitis tenetur quibusdam officiis.\n\nConsequatur magnam nisi placeat quidem et facilis tenetur tempore. Asperiores ipsa exercitationem et ut. Qui suscipit debitis sit molestiae quis omnis a. Sapiente voluptas est occaecati facilis quod ipsam.\n\nIpsam quia eius et et et. Qui ducimus consequatur quis doloribus nemo quo natus. Enim aperiam molestiae et minima deleniti eum veniam fuga.",
                "author" => "Gage Bogan"
            ],
            [
                "id" => 75134,
                "title" => "Corporis sunt neque assumenda.",
                "description" => "Amet libero beatae accusamus in quaerat aut iste. Accusamus perspiciatis voluptatem omnis animi. Est quis odio eligendi pariatur voluptatibus expedita hic.",
                "text" => "Perferendis accusamus quasi qui ipsa dolorem autem ut. Quia rerum consequatur aliquam. Aut quo eligendi voluptatum maiores facilis ut. Sapiente quae dicta sunt consequuntur eveniet.\n\nDolorem dolorem sit dolores ipsa et expedita asperiores. Voluptas ea vitae porro ullam consequatur veniam autem.\n\nLaudantium aut aut ex repellat quisquam. Et maxime ratione non occaecati dolor maiores. Tempora culpa voluptatem aut deleniti repudiandae explicabo est.\n\nQuae quaerat dolorem exercitationem magni. Consequatur fuga nesciunt debitis ipsa. Corporis fugit veniam illum qui consequatur quasi.\n\nEt reiciendis exercitationem quis sunt magni. Qui unde qui rerum. Quo quia et tempore veniam sit aperiam. Dolores incidunt reprehenderit iure velit necessitatibus et.",
                "author" => "Miss Justina Swift V"
            ],
        ];
    }

    public static function find($id) {
        $posts = self::all();
        foreach($posts as $post) {
            if($post['id'] == $id) {
                return $post;
            }
        }
        return null;
    }
};

?>