import React from "react";
import { createBrowserRouter } from "react-router-dom";
import Register from "../components/register/register";
import Login from "../components/login/login";
import InfiniteScroll from "../components/InfiniteScroll/InfiniteScroll";

import AuthLayout from "../layouts/AuthLayout";
import MainLayout from "../layouts/MainLayout";
import Profile from "../components/profile/Profile";

export const AppRoutes = createBrowserRouter([
  {
    path: "",
    element: <AuthLayout />,
    children: [
      {
        path: "",
        element: <Login />,
      },
      {
        path: "/register",
        element: <Register />,
      },
    ],
  },
  {
    path: "/home",
    element: <MainLayout />,
    children: [
      {
        path: "",
        element: <InfiniteScroll />,
      },
    ],
  },
  {
    path: "/profile",
    element: <MainLayout />,
    children: [
      {
        path: "",
        element: <Profile />,
      },
    ],
  },
]);
