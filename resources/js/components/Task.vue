<script setup></script>
<template>
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8">
                <h1>Task Form</h1>
                <form @submit.prevent="saveTask">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                            <input
                                class="form-control form-control-sm"
                                placeholder="Title"
                                v-model="newTask.title"
                                required
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"
                            >Description</label
                        >
                        <div class="col-sm-10">
                            <textarea
                                class="form-control"
                                placeholder="Description"
                                v-model="newTask.description"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Due Date</label>
                        <div class="col-sm-10">
                            <input
                                type="date"
                                class="form-control"
                                v-model="newTask.due_date"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select
                                class="form-control"
                                v-model="newTask.status"
                                required
                            >
                                <option disabled value="">
                                    Please select one
                                </option>
                                <option value="pending">Pending</option>
                                <option value="in-progress">In-Progress</option>
                                <option value="completed">Compeleted</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
            <form @submit.prevent="addTask">
                <label>Title:</label>
                <input v-model="newTask.title" required />
                <label>Description:</label>
                <textarea v-model="newTask.description"></textarea>
                <label>Due Date:</label>
                <input type="date" v-model="newTask.due_date" />
                <label>Status:</label>
                <select v-model="newTask.status">
                    <option disabled value="">Please select one</option>
                    <option value="pending">Pending</option>
                    <option value="in-progress">In-Progress</option>
                    <option value="compeleted">Compeleted</option>
                </select>

                <button type="submit">Add Task</button>
            </form>
        </div> -->

        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-12">
                <h1>Task List</h1>
                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in tasks" :key="task.id">
                            <td>{{ task.title }}</td>
                            <td>{{ task.description }}</td>
                            <td>{{ task.due_date }}</td>
                            <td>{{ ucFirst(task.status) }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-warning mt-2 btn-md"
                                    @click="editTask(task)"
                                >
                                    Edit
                                </button>
                                &nbsp;
                                <button
                                    type="button"
                                    class="btn btn-danger mt-2 btn-md"
                                    @click="deleteTask(task.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tasks: [],
            newTask: {
                title: "",
                description: "",
                due_date: "",
                status: "",
            },
        };
    },
    created() {
        this.fetchTasks();
    },
    methods: {
        ucFirst(value) {
            if (!value) return "";
            return value.charAt(0).toUpperCase() + value.slice(1);
        },
        fetchTasks() {
            axios.get("/api/tasks").then((response) => {
                this.tasks = response.data;
            });
        },
        saveTask() {
            if (this.newTask.id == null || this.newTask.id == 0) this.addTask();
            else this.updateTask(this.newTask.id);
        },
        addTask() {
            let isConfirm = confirm(
                `Are you sure? Do you want to Add new task?`
            );
            if (isConfirm) {
                axios
                    .post("/api/tasks", this.newTask)
                    .then((response) => {
                        this.tasks.unshift(response.data.data);
                        this.newTask = {
                            title: "",
                            description: "",
                            due_date: "",
                            status: "",
                        };
                    })
                    .catch(function (error) {
                        alert(error.response.data.error);
                    });
            }
        },
        editTask(task) {
            this.newTask = { ...task };
        },
        updateTask(taskId) {
            let isConfirm = confirm(
                `Are you sure? Do you want to update the task?`
            );
            if (isConfirm) {
                axios
                    .put(`/api/tasks/${taskId}`, this.newTask)
                    .then(() => {
                        this.fetchTasks();
                        this.newTask = {
                            title: "",
                            description: "",
                            due_date: "",
                            status: "",
                        };
                    })
                    .catch(function (error) {
                        alert(error.response.data.error);
                    });
            }
        },
        deleteTask(taskId) {
            let isConfirm = confirm(
                `Are you sure? Do you want to cancel the task?`
            );
            if (isConfirm) {
                axios
                    .delete(`/api/tasks/${taskId}`)
                    .then(() => {
                        this.tasks = this.tasks.filter(
                            (task) => task.id !== taskId
                        );
                    })
                    .catch(function (error) {
                        alert(error.response.data.error);
                    });
            }
        },
    },
};
</script>
