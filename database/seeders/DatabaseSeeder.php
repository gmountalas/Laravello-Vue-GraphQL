<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Card;
use App\Models\CardList;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 Users
        User::factory(10)->create();

        // Create 3 Boards
        $board1 = Board::create([
            'title' => 'Groceries', 'color' => 'teal', 'owner_id' => 1
        ]);
        $board2 = Board::create([
            'title' => 'Work', 'color' => 'orange', 'owner_id' => 2
        ]);
        $board3 = Board::create([
            'title' => 'Hobby', 'color' => 'indigo', 'owner_id' => 1
        ]);

        // Convert an array of Boards to Collection and iterate over each item
        collect([$board1, $board2, $board3])->each(function (Board $board) {
            // Create 3 CardLists that belong to a Board
            $list1 = CardList::create([
                'title' => 'To-Do', 'board_id' => $board->id
            ]);
            $list2 = CardList::create([
                'title' => 'In progress', 'board_id' => $board->id
            ]);
            $list3 = CardList::create([
                'title' => 'Done', 'board_id' => $board->id
            ]);

            // Convert an array of CardLists to Collection and iterate over each item
            collect([$list1, $list2, $list3])->each(function (CardList $list) use ($board) {
                $order = 1;
                // Iterate over the items of a Collection of "tasks" and attach it to a Card with increasing order
                collect([
                    'Buy groceries',
                    'Take the dog for a walk',
                    'Pay the bills',
                    'Get the car fixed',
                    'Write novel',
                    'Buy food',
                    'Paint a picture',
                    'Create a course'
                  ])->random(random_int(2, 5))->each(function (string $task) use ($board, $list, $order) {
                      $list->cards()->save(
                          Card::make(['title' => $task, 'owner_id' => $board->owner_id, 'order' => $order++])
                      );                    
                  });
            });
        });

    }
}
