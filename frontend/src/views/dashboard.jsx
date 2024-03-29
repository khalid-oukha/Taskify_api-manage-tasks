import { Navigate } from "react-router-dom";
import axiosFront from "../axios-front";

export default function Dashboard() {
    const token = localStorage.getItem('token');
    if (!token) {
        return <Navigate to='/login' />
    }
    const logout = () => {
        axiosFront.post('logout').then(() => {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }).catch((error) => {
            console.log(error);
        });
    }
    return (
        <div>
            <h1>Dashboard</h1>
            <button onClick={logout}>Logout</button>
        </div>
    )
}