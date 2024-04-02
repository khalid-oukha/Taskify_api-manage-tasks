import React from 'react'
import ReactDOM from 'react-dom/client'
import './index.css'
import { RouterProvider } from 'react-router-dom'
import router from './router.jsx'
import { ContextHelper } from './context/ContextHelper.jsx'
ReactDOM.createRoot(document.getElementById('root')).render(
  <ContextHelper>
    <RouterProvider router={router} />
  </ContextHelper>
)
