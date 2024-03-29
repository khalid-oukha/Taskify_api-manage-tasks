import {createBrowserRouter} from 'react-router-dom';
import Login from './views/login.jsx';
import Signup from './views/signup.jsx';
import Dashboard from './views/dashboard.jsx';
const router = createBrowserRouter([
    {
        path: '/login',
        element: <Login />
    },
    {
        path: '/signup',
        element: <Signup />
    },
    {
        path: '/',
        element: <Dashboard />
    }

]);
export default router;
