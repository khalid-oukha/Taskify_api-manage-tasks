import { createContext, useContext, useState } from "react";

const StateContext = createContext(
    {
        user: null,
        token: null,
        setUser: () => {},
        setToken: () => {},

    },
);


export const ContextHelper = ({children}) => {
    const [user, _setUser] = useState(localStorage.getItem('user'));
    const [token, _setToken] = useState(localStorage.getItem('token'));
    const setToken = (token) => {
        _setToken(token);
        if (token) {
            localStorage.setItem('token', token);
        }
        else {
            localStorage.removeItem('token');
        }
    }
    const setUser = (user) => {
        _setUser(user);
        if (user) {
            localStorage.setItem('user', JSON.stringify(user));
        }
        else {
            localStorage.removeItem('user');
        }
    }

    return (
        <StateContext.Provider value={{user, token, setUser, setToken}}>
            {children}
        </StateContext.Provider>
    )
}
export const useGlobalState = () => {
    return useContext(StateContext);
}