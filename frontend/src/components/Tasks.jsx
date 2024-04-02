import React, { useEffect, useState } from 'react'
import { ContextHelper, useGlobalState } from '../context/ContextHelper';
import Task from './Task';
import axiosFront from '../axios-front';
import { Navigate } from 'react-router-dom';
export default function Tasks({tasks, setTasks}) {

    const { user, token } = useGlobalState();
    if (!token) {
        return <Navigate to="/login" />
    }
    
    return (
        <>
            <section className="py-4">
                {
                    tasks &&
                    <div className="container-xl lg:container m-auto">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-lg">
                            {
                                tasks.map((task) => {
                                    return (
                                        <Task task={task} setTasks={setTasks} key={task.id} />
                                    )
                                })
                            }
                        </div>
                    </div>
                }
            </section>

        </>
    )
}
