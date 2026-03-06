<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    public $users = [];

    public function render()
    {
        $this->users = User::select('user_firstName','user_lastName')->get();
        return $this->view();
    }
};
?>

<div class="container">
    <div>
        <h1>Users</h1>
        
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->user_firstName }}</td>
                    <td>{{ $user->user_lastName }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>