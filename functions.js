document.addEventListener("DOMContentLoaded", () => {
    let createTaskForm = document.getElementById("create-task-form");
    let editTaskForm = document.getElementById("edit-task-form");

    if(editTaskForm){
        editTaskForm.addEventListener("submit", editTask);
    }

    if(createTaskForm){
        createTaskForm.addEventListener("submit", createTask);
    }

    let searchInput = document.getElementById("search-input");
    if(searchInput)
    searchInput.addEventListener("keydown", search);
            
});

function createTask(event) {
    console.log("hello");
        event.preventDefault();
        const formData = new FormData(document.getElementById("create-task-form"));
        let errors = validate(formData);
        console.log(
                JSON.stringify(formData));
        if(errors.length == 0){           
            const url = '/task-manager/backend/create-task.php';
            fetch(url, {
                method: 'POST', // Specify the HTTP method
                headers: {
                    'Content-Type': 'application/json' // Inform the server about the data format
                },
                body: JSON.stringify(Object.fromEntries(formData)) // Convert JavaScript object to a JSON string
            })
            .then(response => {
                    console.log(response);

                    if (!response.ok) {
                        document.getElementById("message").innerHTML = 'error';
                        document.getElementById("message").style = 'color:red;'
                        throw new Error('Network response was not ok');
                        
                    }
                // return response.json(); // Parse JSON response from the server
                    console.log(response.json());
                })
                .then(result => {
                    document.getElementById("message").innerHTML = 'Task created Successfully';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById("message").innerHTML = 'error';
                    document.getElementById("message").style = 'color:red;'

                });
            }
        else{
            for(let i = 0; i < errors.length; i++) {
                    for (key in errors[i]) {
                    document.getElementById(key + "-error").innerHTML = errors[i][key];
                    document.getElementById(key + "-error").style = 'color:red';
                }
                
        }
    }


};


function validate(formData) {
    let errors = [];
      Object.entries(Object.fromEntries(formData)).forEach((element) => {
            if(element[1].length == 0){
                let error = {};
                error[element[0]] = element[0] + " cannot be empty";
                errors.push(error)
            }
            else{

                if(element[0] == 'priority'){
                    console.log(element[1]);
                    if(element[1] !== 'low' && element[1] !== 'medium' && element[1] !== 'high'){
                        let error = {};
                        error[element[0]] = element[0] + " has wrong value";
                        errors.push(error)
                    }
                }

                if(element[0] == 'due_date'){
                    if(isNaN(Date.parse(element[1]))){
                        let error = {};
                        error[element[0]] = element[0] + " is not a valid date";
                        errors.push(error)
                    }
                }
            }
        });    
        return errors;
}

function deleteTask(id) {
    const url = '/task-manager/backend/delete-task.php';
    let formData = new FormData();
    formData.append("id", id);
    fetch(url, {
        method: 'delete', // Specify the HTTP method
        headers: {
            'Content-Type': 'application/json' // Inform the server about the data format
        },
        body: JSON.stringify(Object.fromEntries(formData)) // Convert JavaScript object to a JSON string
    })
    .then(response => {;
        if (!response.ok) {
            document.getElementById("message").innerHTML = 'error';
            document.getElementById("message").style = 'color:red;'
            throw new Error('Network response was not ok');

        }
        // return response.json(); // Parse JSON response from the server
        console.log(response.json());
    })
    .then(result => {
        document.getElementById("message").innerHTML = 'Task Created Successfully';
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById("message").innerHTML = error;
        document.getElementById("message").style = 'color:red;'

    });
}

function editTask(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById("edit-task-form"));
            let errors = validate(formData);
            console.log(
                    JSON.stringify(formData));
            if(errors.length == 0){           
                const url = '/task-manager/backend/update-task.php';
                fetch(url, {
                    method: 'POST', // Specify the HTTP method
                    headers: {
                        'Content-Type': 'application/json' // Inform the server about the data format
                    },
                    body: JSON.stringify(Object.fromEntries(formData)) // Convert JavaScript object to a JSON string
                })
                .then(response => {
                    console.log(response);

                    if (!response.ok) {
                        document.getElementById("message").innerHTML = 'error';
                        document.getElementById("message").style = 'color:red;'
                        throw new Error('Network response was not ok');
                        
                    }
                // return response.json(); // Parse JSON response from the server
                    console.log(response.json());
                })
                .then(result => {
                    document.getElementById("message").innerHTML = 'Task updated Successfully';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById("message").innerHTML = 'error';
                    document.getElementById("message").style = 'color:red;'

                });
            }
            else{
                for(let i = 0; i < errors.length; i++) {
                        for (key in errors[i]) {
                        document.getElementById(key + "-error").innerHTML = errors[i][key];
                        document.getElementById(key + "-error").style = 'color:red';
                    }
                    
            }
        }
    
    
    }

function search() {
    let value = document.getElementById("search-input").value;

    const formData = new FormData();
    formData.append("word", value);
            
    const url = '/task-manager/backend/search.php';
    fetch(url, {
        method: 'POST', // Specify the HTTP method
        headers: {
            'Content-Type': 'application/json' // Inform the server about the data format
        },
        body: JSON.stringify(Object.fromEntries(formData)) // Convert JavaScript object to a JSON string
    })
    .then(response => {

        if (!response.ok) {
            document.getElementById("message").innerHTML = 'error';
            document.getElementById("message").style = 'color:red;'
            throw new Error('Network response was not ok');
            
        }

        return response.json();
        

    })
    .then(result => {
        if(result.tasks.length){
            document.getElementById("tasks").innerHTML = '';

            result.tasks.forEach((task) => {
                document.getElementById("tasks").innerHTML +=
                    `<div class="task" id="task-${task.id}">
                        <li><span>Title: </span><input disabled value="${task.title}" /></li>
                        <li><span>Description: </span><input disabled value="${task.description}" /></li>
                        <li><span>Priority: </span><input disabled value="${task.priority}" /></li>
                        <li><span>Status: </span><input disabled value="${task.status}" /></li>
                        <li><span>Due Date: </span><input disabled value="${task.due_date}" /></span>
                        <li><a id="edit-button" href="edit-task.php?id=${task.id}">Edit</a></li>
                        <li><button style="background-color: red;" onclick="deleteTask(${task.id})">Delete</button></li>
                    </div>`
                
            });
        }
        else{
            document.getElementById("tasks").innerHTML = 'No results found';
        }
    })
    .catch(error => {
        console.error('Error:', error);

    });
}

function filterByStatus(value) {
    
    const formData = new FormData();
    formData.append("filter", value);
            
    const url = '/task-manager/backend/filter-by-status.php';
    fetch(url, {
        method: 'POST', // Specify the HTTP method
        headers: {
            'Content-Type': 'application/json' // Inform the server about the data format
        },
        body: JSON.stringify(Object.fromEntries(formData)) // Convert JavaScript object to a JSON string
    })
    .then(response => {

        if (!response.ok) {
            document.getElementById("message").innerHTML = 'error';
            document.getElementById("message").style = 'color:red;'
            throw new Error('Network response was not ok');
            
        }

        return response.json();
        

    })
    .then(result => {
        if(result.tasks.length){
            document.getElementById("tasks").innerHTML = '';

            result.tasks.forEach((task) => {
                document.getElementById("tasks").innerHTML +=
                    `<div class="task" id="task-${task.id}">
                        <li><span>Title: </span><input disabled value="${task.title}" /></li>
                        <li><span>Description: </span><input disabled value="${task.description}" /></li>
                        <li><span>Priority: </span><input disabled value="${task.priority}" /></li>
                        <li><span>Status: </span><input disabled value="${task.status}" /></li>
                        <li><span>Due Date: </span><input disabled value="${task.due_date}" /></span>
                        <li><a id="edit-button" href="edit-task.php?id=${task.id}">Edit</a></li>
                        <li><button style="background-color: red;" onclick="deleteTask(${task.id})">Delete</button></li>
                    </div>`
                
            });
        }
        else{
            document.getElementById("tasks").innerHTML = 'No results found';
        }
    })
    .catch(error => {
        console.error('Error:', error);

    });
}

function filterByPriority(value) {
    
    const formData = new FormData();
    formData.append("filter", value);
            
    const url = '/task-manager/backend/filter-by-priority.php';
    fetch(url, {
        method: 'POST', // Specify the HTTP method
        headers: {
            'Content-Type': 'application/json' // Inform the server about the data format
        },
        body: JSON.stringify(Object.fromEntries(formData)) // Convert JavaScript object to a JSON string
    })
    .then(response => {

        if (!response.ok) {
            document.getElementById("message").innerHTML = 'error';
            document.getElementById("message").style = 'color:red;'
            throw new Error('Network response was not ok');
            
        }

        return response.json();
        

    })
    .then(result => {
        if(result.tasks.length){
            document.getElementById("tasks").innerHTML = '';

            result.tasks.forEach((task) => {
                document.getElementById("tasks").innerHTML +=
                    `<div class="task" id="task-${task.id}">
                        <li><span>Title: </span><input disabled value="${task.title}" /></li>
                        <li><span>Description: </span><input disabled value="${task.description}" /></li>
                        <li><span>Priority: </span><input disabled value="${task.priority}" /></li>
                        <li><span>Status: </span><input disabled value="${task.status}" /></li>
                        <li><span>Due Date: </span><input disabled value="${task.due_date}" /></span>
                        <li><a id="edit-button" href="edit-task.php?id=${task.id}">Edit</a></li>
                        <li><button style="background-color: red;" onclick="deleteTask(${task.id})">Delete</button></li>
                    </div>`
                
            });
        }
        else{
            document.getElementById("tasks").innerHTML = 'No results found';
        }
    })
    .catch(error => {
        console.error('Error:', error);

    });
}







