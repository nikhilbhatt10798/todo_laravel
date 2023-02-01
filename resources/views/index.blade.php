<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"></head>
<body>
    <header>
        <h2 style="text-align: center">TODO</h2>
    </header>
    <main>
        <div class="container card">
            <div class="show-All-task">
                <input type="checkbox" id="showAllTaskId" onclick="showAllTask()">
                <label>show All Task</label>
            </div>
            <div class="task ">
                <div class="d-flex  bg-light">
                    <div class="col-sm-1 "> <i class="fa fa-user" aria-hidden="true"></i></div>
                        <div class="col-sm-10 ">
                            <input type="text" placeholder="Enter Task" id="task" name="task" class="form-control">
                        </div>
                        <button class="btn btn-success" onclick="addTask()">Add</button>
                    </form>
                </div>
                <div class="card mt-4">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                               <th colspan="4" style="text-align: center">Task List</th>
                            </tr>
                        </thead>
                        <tbody id="taskList">
                            @forelse ( $task as $row )
                            <tr scope="row">
                                <td width="10%"><input type="checkbox" class="completeCheckbox" onclick="CompleteTask('{{ $row->id }}')"></td>
                                <td width="70%">{{ $row->task }}</td>
                                <td width="10%">{{ $row->status }}</td>
                                <td width="10%"><button class="btn btn-danger"  data-toggle="modal" data-target="#deleteConfirmModal" onclick="deleteModal('{{ $row->id }}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                            </tr>
                            @empty
                            <tr >
                                <td colspan="4"> You have no task to do </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmation Modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Are You sure ?  you want to delete.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="deleteTask" class="btn btn-primary" onclick="deleteTask()" data-id="">Yes</button>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script>
    function addTask(){
        let task = $('#task').val();
        console.log(task);
        let token = "{{ csrf_token() }}";
        console.log(token);
        $.ajax({
            type:"Post",
            url : "{{ route('addTask') }}",
            data : {
                "_token":token,
                task : task,
                status : "Pending",
            },
            success:function(data){
                console.log(data);
                if(data.status=="success"){
                    let html = "";
                    let taskList = data.data;
                    console.log(taskList);
                    taskList.forEach(htmlfunction)
                    $('#taskList').html(html);
                    $('#showAllTaskId').attr('checked',false);
                    $('#task').val('');
                    function htmlfunction(ele,index){
                        html += ` <tr scope="row">
                                <td width="10%"><input type="checkbox" id="${ele.id}" class="completeCheckbox" onclick="CompleteTask('${ele.id}')" data-id="${ele.id}"></td>
                                <td width="70%">${ele.task}</td>
                                <td width="10%">${ele.status}</td>
                                <td width="10%"><button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmModal"  onclick="deleteModal('${ele.id}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                            </tr>`;
                    }
                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function CompleteTask(id){
        let check = $('#'+id).is(':checked');
        console.log(check);
        if(check == true){
            let token = "{{ csrf_token() }}";
            console.log(token);
        $.ajax({
            type:"post",
            url : "{{ route('completeTask') }}",
            data : {
                "_token":token,
                id : id,
            },
            success:function(data){
                console.log(data);
                if(data.status=="success"){
                    let html = "";
                    let taskList = data.data;
                    console.log(taskList);
                    taskList.forEach(htmlfunction)
                    $('#taskList').html(html);
                    $('#showAllTaskId').attr('checked',false);
                    $('.completeCheckbox').attr('checked',false);

                    function htmlfunction(ele,index){
                        html += ` <tr scope="row">
                                <td width="10%"><input type="checkbox" id="${ele.id}" class="completeCheckbox" onclick="CompleteTask('${ele.id}')" data-id="${ele.id}"></td>
                                <td width="70%">${ele.task}</td>
                                <td width="10%">${ele.status}</td>
                                <td width="10%"><button class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmModal"  onclick="deleteModal('${ele.id}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                            </tr>`;
                    }
                }
            },
            error:function(error){
                console.log(error);
            }
        });
        }
    }

    function showAllTask(){
        let check = $('#showAllTaskId').is(':checked');
        console.log(check);
        if(check == true){
            let token = "{{ csrf_token() }}";
            console.log(token);
            $.ajax({
                type:"GET",
                url : "{{ route('showAllTask') }}",
                dataType: 'json',
                success:function(data){
                    console.log(data);
                    if(data.status=="success"){
                        let html = "";
                        let taskList = data.data;
                        console.log(taskList);
                        taskList.forEach(htmlfunction)
                        $('#taskList').html(html);
                        function htmlfunction(ele,index){
                            html += ` <tr scope="row">
                                    <td width="10%"><input type="checkbox" id="${ele.id}" class="completeCheckbox" onclick="CompleteTask('${ele.id}')" data-id="${ele.id}"></td>
                                    <td width="70%">${ele.task}</td>
                                    <td width="10%">${ele.status}</td>
                                    <td width="10%"><button class="btn btn-danger"   data-toggle="modal" data-target="#deleteConfirmModal"  onclick="deleteModal('${ele.id}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                                </tr>`;
                        }
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    }

    function deleteTask(){
        let id = $('#deleteTask').attr('data-id');
        let token = "{{ csrf_token() }}";
        console.log(token);
        $.ajax({
            type:"post",
            url : "{{ route('deleteTask') }}",
            data : {
                "_token":token,
                id : id,
            },
            success:function(data){
                console.log(data);
                if(data.status=="success"){
                    let html = "";
                    let taskList = data.data;
                    console.log(taskList);
                    taskList.forEach(htmlfunction)
                    $('#taskList').html(html);
                    $('#deleteConfirmModal').modal('hide');
                    $('#showAllTaskId').prop('checked', false);
                    function htmlfunction(ele,index){
                        html += ` <tr scope="row">
                                <td width="10%"><input type="checkbox" id="${ele.id}" class="completeCheckbox" onclick="CompleteTask('${ele.id}')" data-id="${ele.id}"></td>
                                <td width="70%">${ele.task}</td>
                                <td width="10%">${ele.status}</td>
                                <td width="10%"><button class="btn btn-danger"   data-toggle="modal" data-target="#deleteConfirmModal"  onclick="deleteModal('${ele.id}')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                            </tr>`;
                    }
                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }
    function deleteModal(id){
        $('#deleteTask').attr('data-id',id);
    }
</script>
</html>
