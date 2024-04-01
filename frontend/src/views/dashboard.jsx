import { Navigate } from "react-router-dom";
import axiosFront from "../axios-front";
import Navbar from "../components/Navbar";
import Hero from "../components/Hero";
import HomeCards from "../components/HomeCards";

export default function Dashboard() {

    return (
        <>
            <Navbar />

            {/* <!-- Hero --> */}
            <Hero />


            {/* <!-- Developers and Employers --> */}
            <HomeCards />

        </>
    )
}