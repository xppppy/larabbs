<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;


class ReplysTableSeeder extends Seeder {

    public function run() {

        //获取所有用户id，并放入数组；
        $user_ids = User::all()->pluck('id')->toArray();

        //获取所有话题id，并放入数组；
        $topic_ids = Topic::all()->pluck('id')->toArray();

        //获取faker实例
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)//获取Reply实例并使用工厂
                        ->times(1000)//生成1000条模拟数据
                        ->make()//执行
                        ->each(//迭代集合中的内容并将其传递到回调函数中
                            function ($reply, $index)
                            use($user_ids,$topic_ids,$faker){

                                    //从用户id数组中随机取出一个并赋值
                                    $reply->user_id = $faker->randomElement($user_ids);

                                   //话题id，同上
                                    $reply->topic_id = $faker->randomElement($topic_ids);

                            });

        // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replys->toArray());
    }

}

