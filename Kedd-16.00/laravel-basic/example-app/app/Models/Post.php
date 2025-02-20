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
                "author" => "Malcolm Heller",
            ],
            [
                "id" => 31057,
                "title" => "Quod recusandae architecto quis repellendus.",
                "description" => "Doloribus est natus vitae voluptas rerum deleniti nemo. Hic repudiandae ut est pariatur assumenda ipsum eos. Corrupti consequatur incidunt quis quia sed natus at consequatur.",
                "text" => "Consequatur id dolores quis et. Tempora iusto sunt aliquam aperiam voluptatem. Laudantium vel voluptatum eos praesentium.\n\nIure quo similique autem dolore. Tempora ea aut tenetur quo aut at. Earum et aliquid et. Est sapiente voluptatibus soluta repellat et.\n\nIllum laudantium aut quod ipsum aut ad. Magni eveniet eligendi maiores rem perferendis ut. Eum maiores dolor perspiciatis et exercitationem.\n\nUnde et illum laborum maiores velit eveniet. Velit asperiores pariatur rerum praesentium libero quae. Et dolores ea tempora tenetur debitis ab autem.\n\nQui voluptatem porro voluptate quia. Laudantium facere ut natus ut id omnis vel officiis. Aperiam esse incidunt et perspiciatis omnis cumque. Et delectus autem quia eos.",
                "author" => "Malcolm Heller",
            ],
            [
                "id" => 31058,
                "title" => "Quod recusandae architecto quis repellendus.",
                "description" => "Doloribus est natus vitae voluptas rerum deleniti nemo. Hic repudiandae ut est pariatur assumenda ipsum eos. Corrupti consequatur incidunt quis quia sed natus at consequatur.",
                "text" => "Consequatur id dolores quis et. Tempora iusto sunt aliquam aperiam voluptatem. Laudantium vel voluptatum eos praesentium.\n\nIure quo similique autem dolore. Tempora ea aut tenetur quo aut at. Earum et aliquid et. Est sapiente voluptatibus soluta repellat et.\n\nIllum laudantium aut quod ipsum aut ad. Magni eveniet eligendi maiores rem perferendis ut. Eum maiores dolor perspiciatis et exercitationem.\n\nUnde et illum laborum maiores velit eveniet. Velit asperiores pariatur rerum praesentium libero quae. Et dolores ea tempora tenetur debitis ab autem.\n\nQui voluptatem porro voluptate quia. Laudantium facere ut natus ut id omnis vel officiis. Aperiam esse incidunt et perspiciatis omnis cumque. Et delectus autem quia eos.",
                "author" => "Malcolm Heller",
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