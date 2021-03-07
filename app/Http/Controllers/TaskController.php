<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskType;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task_types = TaskType::all();
        return view('tasks.create', compact("task_types"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'task_name' => 'required',
            'task_description' => 'required',
            'task_datetime' => 'required'
        ]);

        Task::create($request->all());
        $client = Client::find($request->input("client_id"));
        User::giveXp($request->input('added_by'), 3);

        return redirect()->route('clients.show', compact("client"))->with('task_success', 'Užduotis suplanuota!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        TaskComment::create($request->all());
        $task_comments = TaskComment::findTaskComment($request->input("task_id"));
        $task = Task::find($request->input("task_id"));
        User::giveXp($request->input('added_by'), 1);

        return redirect()->route('tasks.edit', compact("task", "task_comments"))->with('comment_success', 'Komentaras pridėtas!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $task_type = Task::findTaskType($task->type_id);

        return view('tasks.show', compact('task', 'task_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $task_comments = TaskComment::findTaskComment($task->id);
        $task_type = TaskType::findTaskType($task->type_id);
        return view('tasks.edit', compact('task', 'task_comments', 'task_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'type_id' => 'required',
            'task_name' => 'required',
            'task_description' => 'required',
            'task_datetime' => 'required'
        ]);

        $task->update($request->all());
        
        // Give xp for completion, successful completion
        if($request->input('task_completed') && !Task::completeXpGiven($task->id)){
            User::giveXp($task->added_by, 3);
            Task::setCompleteXpGiven($task->id);
        }

        if($request->input('task_succesful') && !Task::successXpGiven($task->id)){
            User::giveXp($task->added_by, 5);
            Task::setSuccessXpGiven($task->id);
        }

        $client = Client::find($task->client_id);

        return redirect()->route('clients.show', compact('task', 'client'))
                        ->with('task_success','Užduotis sėkmingai atnaujinta!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $client = Client::find($task->client_id);
        $task->delete();

        return redirect()->route('clients.show', compact('client'))
                        ->with('task_success','Užduotis ištrinta!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroyComment(TaskComment $comment)
    {
        $task = Task::find($comment->task_id);
        $comment->delete();

        return redirect()->route('tasks.edit', compact('task'))
                        ->with('comment_success','Komentaras ištrintas!');
    }
}
