import React from "react";
import { createBrowserRouter } from "react-router-dom";
import Register from "../components/register/register";
import Login from "../components/login/login";
import AuthLayout from "../layouts/AuthLayout";

export const AppRoutes = createBrowserRouter([
  {
    path: "/",
    element: <AuthLayout />,
    children: [
      {
        path: "/",
        element: <Login />,
      },
      {
        path: "/register",
        element: <Register />,
      },
    ],
  },
]);
