import { Button, Label, Modal, Select, TextInput } from "flowbite-react";
import { React, useState } from 'react';
import logo from '../components/assets/images/logo.png'
import { Navigate } from "react-router-dom";
import axiosFront from "../axios-front";

export default function Navbar({setTesks}) {

    const token = localStorage.getItem('token');
    if (!token) {
        return <Navigate to='/login' />
    }

    const [openModal, setOpenModal] = useState(false);

    const logout = () => {
        axiosFront.post('logout').then(() => {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }).catch((error) => {
            console.log(error);
        });
    }

    const createTask = (event) => {
        event.preventDefault(); 

        const taskName = event.target.name.value;
        const taskStatus = event.target.status.value;

        axiosFront.post('v1/usertask', { name: taskName, status: taskStatus }).then((res) => {
            console.log('Task created');
            setTesks(res.data.tasks);
            setOpenModal(false); // Close the modal after task creation
        }).catch((error) => {
            console.log(error);
        });
    }
    return (
        <>

            <nav className="bg-indigo-700 border-b border-indigo-500">
                <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div className="flex h-20 items-center justify-between">
                        <div
                            className="flex flex-1 items-center justify-center md:items-stretch md:justify-start"
                        >
                            {/* <!-- Logo --> */}
                            <a className="flex flex-shrink-0 items-center mr-4" href="/index.html">
                                <img
                                    className="h-10 w-auto"
                                    src={logo}
                                    alt="React Jobs"
                                />
                                <span className="hidden md:block text-white text-2xl font-bold ml-2"
                                >Taskify App </span>
                            </a>
                            <div className="md:ml-auto">
                                <div className="flex space-x-2">
                                    <a
                                        href="/index.html"
                                        className="text-white bg-black hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                                    >Home</a
                                    >
                                    <a
                                        href="/jobs.html"
                                        className="text-white hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                                    >Jobs</a
                                    >
                                    <Button onClick={() => setOpenModal(true)}>Add new Task</Button>
                                    <Modal show={openModal} size="md" onClose={() => setOpenModal(false)} popup>
                                        <Modal.Header />
                                        <Modal.Body>
                                            <div className="text-center">
                                                <h3 className="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Are you sure you want to delete this product?
                                                </h3>



                                                <form onSubmit={createTask} className="flex max-w-md flex-col gap-4">
                                                    <div>
                                                        <div className="mb-2 block">
                                                            <Label htmlFor="task" value="Task name" />
                                                        </div>
                                                        <TextInput id="name" name="name" type="text" placeholder="Task name" required />
                                                    </div>
                                                    <div>
                                                        <div className="mb-2 block">
                                                            <Label htmlFor="status" value="Select Task status" />
                                                        </div>
                                                        <Select id="status" name="status" required>
                                                            <option value="to do">To Do</option>
                                                            <option value="doing">Doing</option>
                                                            <option value="done">Done</option>
                                                        </Select>
                                                    </div>
                                                    <Button type="submit">Submit</Button>
                                                </form>

                                            </div>
                                        </Modal.Body>
                                    </Modal>
                                    <button className="text-white hover:bg-gray-900 hover:text-white rounded-md px-3 py-2" onClick={logout}>Logout</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>



        </>
    )
}
