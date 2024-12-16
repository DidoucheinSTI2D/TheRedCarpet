import React from "react";
import { createBrowserRouter } from "react-router-dom";
import Register from "../components/register/register";
import Login from "../components/login/login";
import InfiniteScroll from "../components/InfiniteScroll/InfiniteScroll"


import AuthLayout from "../layouts/AuthLayout";
import MainLayout from "../layouts/MainLayout"

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
  {
    path: "/test",
    element: <MainLayout />,
    children: [
      {
        path: "/test",
        element: <InfiniteScroll />,
      },
    ],
  },
]);
