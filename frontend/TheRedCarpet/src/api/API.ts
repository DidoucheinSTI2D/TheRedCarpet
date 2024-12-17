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


export const getOngoingRepresentations = async () => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend/";
    const response = await fetch(`${apiHost}/API/representation/getOngoingRepresentations.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to fetch ongoing representations.",
        error: true,
      };
    }
  } catch (err: any) {
    return {
      message: "Failed to connect to the server. " + err.message,
      error: true,
    };
  }
};

export const countSpectaclesByCategory = async () => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/countSpectacle.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to count spectacles by category.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const filterSpectacles = async (filter: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/filterSpectacle.php?filter=${encodeURIComponent(filter)}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to fetch spectacles.",
        error: true,
      };
    }
  } catch (err: unknown) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const deleteCategory = async (categoryId: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/deleteCategory.php`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: categoryId }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to delete category.",
        error: true,
      };
    }
  } catch (err: any) {
    return {
      message: "Failed to connect to the server. " + err.message,
      error: true,
    };
  }
};

export const deleteSpectacle = async (spectacleId: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/deleteSpectacle.php`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: spectacleId }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to delete spectacle.",
        error: true,
      };
    }
  } catch (err: unknown) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};


export const getSpectaclesByBorough = async (borough: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/getSpectacleByBorough.php?borough=${encodeURIComponent(borough)}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to fetch spectacles by borough.",
        error: true,
      };
    }
  } catch (err: unknown) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const createCategory = async (name: string, helpText: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/newCategory.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ name, helpText }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to create category.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const createSpectacle = async (title: string, synopsis: string, duration: number, price: number, language: string, categoryId: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/newSpectacle.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ title, synopsis, duration, price, language, category_id: categoryId }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to create spectacle.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const getOngoingSpectaclesByCategory = async (categoryId: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/onGoingSpectacle.php?category_id=${encodeURIComponent(categoryId)}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to fetch ongoing spectacles.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const getRecepyPerSpectacle = async () => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/RecepyPerSpectacle.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to retrieve revenue per spectacle.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const getTopThreeSpectacles = async () => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/TopThreeSpectacles.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to retrieve top three spectacles.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const updateCategory = async (id: string, name: string, helpText: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/spectacle/updateCategory.php`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id, name, helpText }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to update category.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const createRepresentation = async (spectacleId: string, date: string, time: string, venue: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/representation/newRepresentation.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ spectacleId, date, time, venue }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to create representation.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const deleteRepresentation = async (firstDate: string, lastDate: string, spectacleId: string, roomId: string) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/representation/deleteRepresentation.php`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ first_date: firstDate, last_date: lastDate, spectacle_id: spectacleId, room_id: roomId }),
    });

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to delete representation.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};

export const getFullyBookedPastShows = async () => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend";
    const response = await fetch(`${apiHost}/API/representation/getFullyBookedPastShows.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    const data = await response.json();

    if (response.ok) {
      return { data: data.data, status: data.status, error: false };
    } else {
      return {
        message: data.message || "Failed to retrieve fully booked past shows.",
        error: true,
      };
    }
  } catch (err) {
    const errorMessage = err instanceof Error ? err.message : "Unknown error";
    return {
      message: "Failed to connect to the server. " + errorMessage,
      error: true,
    };
  }
};