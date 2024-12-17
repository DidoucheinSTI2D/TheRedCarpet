interface RegisterParams {
  username: string;
  password: string;
  email: string;
  birthdate: string;
  first_name: string;
  last_name: string;
}

export const getRegister = async ({
  username,
  password,
  email,
  birthdate,
  first_name,
  last_name,
}: RegisterParams) => {
  try {
    const apiHost =
      import.meta.env.VITE_API_HOST ||
      "http://localhost:8888/TheRedCarpet/Backend/";
    const response = await fetch(`${apiHost}/API/user/register.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: username,
        password: password,
        email: email,
        birthdate: birthdate,
        first_name: first_name,
        last_name: last_name,
      }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, error: false };
    } else {
      return { message: data.message || "An error occurred.", error: true };
    }
  } catch (err: any) {
    return {
      message: "Failed to connect to the server. " + err.message,
      error: true,
    };
  }
};

export const getLogin = async (username: string, password: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888";
    const response = await fetch(`${apiHost}/API/user/login.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: username,
        password: password,
      }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, error: false, user: data.user };
    } else {
      return { message: data.message || "Login failed.", error: true };
    }
  } catch (err: any) {
    return {
      message: "Failed to connect to the server. " + err.message,
      error: true,
    };
  }
};

export const getDistinctLieux = async () => {
  try {
    const apiHost =
      import.meta.env.VITE_API_HOST || "http://localhost:8888";
    const response = await fetch(`${apiHost}/API/spectacles/lieux.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { lieux: data.lieux, error: false };
    } else {
      return { message: data.message || "An error occurred.", error: true };
    }
  } catch (err: any) {
    return {
      message: "Failed to connect to the server. " + err.message,
      error: true,
    };
  }
};
