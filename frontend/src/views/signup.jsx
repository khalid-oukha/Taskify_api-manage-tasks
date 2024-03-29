import { useRef } from "react";
import { useGlobalState } from "../context/ContextHelper";
import axiosFront from "../axios-front";

export default function  Signup() {
    const nameRef = useRef();
    const emailRef = useRef();
    const passwordRef = useRef();
    const {setToken,setUser} = useGlobalState();
    const onSubmit = async (e) => {
        e.preventDefault();
        const playload = {
            name: nameRef.current.value,
            email: emailRef.current.value,
            password: passwordRef.current.value,
        }
        axiosFront.post('/register', playload).then((response) => {
            setToken(response.data.authorization.token);
            setUser(response.data.user);
            window.location.href = "/";
        }
        ).catch((error) => {
            console.log(error);
        });

    }
    return (
        <div>

            <div className="container">
                <div className="screen">
                    <div className="screen__content">
                        <form className="login" onSubmit={onSubmit}>
                            <div className="login__field">
                                <i className="login__icon fas fa-user"></i>
                                <input ref={nameRef} type="text" className="login__input" placeholder="User name / Email"/>
                            </div>
                            <div className="login__field">
                                <i className="login__icon fas fa-user"></i>
                                <input ref={emailRef} type="text" className="login__input" placeholder="User name / Email"/>
                            </div>
                            <div className="login__field">
                                <i className="login__icon fas fa-lock"></i>
                                <input ref={passwordRef} type="password" className="login__input" placeholder="Password"/>
                            </div>
                            <button className="button login__submit">
                                <span className="button__text">Log In Now</span>
                                <i className="button__icon fas fa-chevron-right"></i>
                            </button>
                        </form>
                        <div className="social-login">
                            <h3>log in via</h3>
                            <div className="social-icons">
                                <a href="#" className="social-login__icon fab fa-instagram"></a>
                                <a href="#" className="social-login__icon fab fa-facebook"></a>
                                <a href="#" className="social-login__icon fab fa-twitter"></a>
                            </div>
                        </div>
                    </div>
                    <div className="screen__background">
                        <span className="screen__background__shape screen__background__shape4"></span>
                        <span className="screen__background__shape screen__background__shape3"></span>
                        <span className="screen__background__shape screen__background__shape2"></span>
                        <span className="screen__background__shape screen__background__shape1"></span>
                    </div>
                </div>
            </div>

        </div>
    )
}