import React, { useState } from 'react'
import { Button, Label, Modal, Select, TextInput } from "flowbite-react";
import { Link } from 'react-router-dom'
import axiosFront from '../axios-front';

export default function Task({ task, setTasks }) {

  const [openModal, setOpenModal] = useState(false);
  const [values, setValues] = useState({
    name: task.name,
    status: task.status
  });

  const handleChnage = (event) => {
    setValues({
      ...values,
      [event.target.name]: event.target.value
    });
  }

  const deleteTask = () => {
    axiosFront.delete(`v1/usertask/${task.id}`)
      .then((res) => {
        // If the deletion is successful, call the onDelete function
        setTasks(res.data.tasks);
      })
      .catch(error => {
        console.error('Error deleting task:', error);
      });
  };

  const editTask = () => {
    event.preventDefault(); // Prevent default form submission

    const taskName = event.target.name.value;
    const taskStatus = event.target.status.value;

    axiosFront.put(`v1/usertask/${task.id}`, { name: taskName, status: taskStatus })
      .then((res) => {
        setTasks(res.data.tasks);
        setOpenModal(false); // Close the modal after task creation
      })
      .catch(error => {
        console.error('Error deleting task:', error);
      });
  };

  const makeDone = () => {
    axiosFront.put(`v1/taskdone/${task.id}`)
      .then((res) => {
        setTasks(res.data.tasks);

      })
      .catch(error => {
        console.error('Error making task done:', error);
      });
  };


  return (
    <div className="bg-gray-100 p-6 rounded-lg shadow-md">
      <div className="bg-gray-100 p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold">{task.name}</h2>
          <p className="mt-2 mb-4">
            {task.status === 'to do' && <span className="bg-red-500 text-white rounded-lg px-2 py-1">To Do</span>}
            {task.status === 'doing' && <span className="bg-yellow-500 text-white rounded-lg px-2 py-1">Doing</span>}
            {task.status === 'done' && <span className="bg-green-500 text-white rounded-lg px-2 py-1">Done</span>}
          </p>
          <p className="mt-2 mb-4">
            Find  Tasks that match your skills and expertise
          </p>
        </div>
        <div className="flex items-center">
          <button
            onClick={deleteTask}
            className="mr-2 inline-block bg-red-500 text-white rounded-lg px-4 py-2 my-2 hover:bg-red-600"
          >
            Delete
          </button>
          <Button className="mr-2 inline-block bg-blue-800 text-white rounded-lg px-4 my-2 hover:bg-gray-600" onClick={() => setOpenModal(true)}>edit</Button>
          {task.status !== 'done' && (
            <button
              onClick={makeDone}
              className="inline-block bg-green-500 text-white rounded-lg px-4 py-2 my-2 hover:bg-indigo-600"
            >
              Done
            </button>
          )}
        </div>
      </div>
      <Modal show={openModal} size="md" onClose={() => setOpenModal(false)} popup>
        <Modal.Header />
        <Modal.Body>
          <div className="text-center">
            <h3 className="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
              Are you sure you want to edit this product?
            </h3>



            <form onSubmit={editTask} className="flex max-w-md flex-col gap-4">
              <div>
                <div className="mb-2 block">
                  <Label htmlFor="task" value="Task name" />
                </div>
                <TextInput id="name" name="name" onChange={handleChnage} value={values.name} type="text" placeholder="Task name" required />
              </div>
              <div>
                <div className="mb-2 block">
                  <Label htmlFor="status" value="Select Task status" />
                </div>
                <Select onChange={handleChnage} value={values.status} id="status" name="status" required>
                  <option value="to do" >To Do</option>
                  <option value="doing" >Doing</option>
                  <option value="done" >Done</option>
                </Select>
              </div>
              <Button type="submit">Submit</Button>
            </form>

          </div>
        </Modal.Body>
      </Modal>
    </div>
  )
}
