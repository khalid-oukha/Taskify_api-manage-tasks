import { Navigate } from "react-router-dom";
import axiosFront from "../axios-front";
import Navbar from "../components/Navbar";
import Hero from "../components/Hero";
import Tasks from "../components/Tasks";
import { useEffect, useState } from "react";

export default function Dashboard() {
    const [tasks, setTesks] = useState([]);


    useEffect(() => {
        axiosFront.get('v1/usertask').then((response) => {
            setTesks(response.data.data);
        }).catch((error) => {
            console.log(error);
        });
    }, [setTesks]);

    return (
        <>
            <Navbar setTesks={setTesks} />

            {/* <!-- Hero --> */}
            <Hero />


            {/* <!-- Developers and Employers --> */}
            <Tasks  tasks = {tasks} setTasks={setTesks} />

        </>
    )
}