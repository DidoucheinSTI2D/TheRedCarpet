import React from "react";
import { useEffect, useState } from "react";
import { useInView } from "react-intersection-observer";
import Post from "../Post/Post";
import { getOngoingRepresentations } from "../../api/API";
import Arrow from "../../assets/DownArrow.svg"

interface Representation {
  first_date: string;
  last_date: string;
  room_id: number;
  spectacle_id: number;
  spectacle_synopsis: string;
  spectacle_title: string;
}

function InfiniteScroll() {
  const [representations, setRepresentations] = useState<Representation[]>([]);
  const [visibleRepresentations, setVisibleRepresentations] = useState<
    Representation[]
  >([]);
  const [position, setPosition] = useState(5);
  const [isLoading, setIsLoading] = useState(true);
  const { ref, inView } = useInView({
    threshold: 0.5,
  });

  useEffect(() => {
    const fetchData = async () => {
      const result = await getOngoingRepresentations();
      if (!result.error) {
        setRepresentations(result.data);
        setVisibleRepresentations(result.data.slice(0, 5));
        setIsLoading(false);
      } else {
        console.error("Error fetching representations:", result.message);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  useEffect(() => {
    if (inView && position < representations.length) {
      const nextBatch = representations.slice(position, position + 5);
      setVisibleRepresentations((prev) => [...prev, ...nextBatch]);
      setPosition((prev) => prev + 5);
    }
  }, [inView, position, representations]);

  if (isLoading) {
    return (
      <div className="flex justify-center items-center h-screen">
        <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-500"></div>
      </div>
    );
  }

  return (
    <div className="flex flex-col items-center justify-center p-4 gap-[4rem]">
      <div className="flex flex-col items-center justify-center h-[20vh] w-full">
        <p className=" text-3xl font-bold">Magic pick</p>
        <p className=" text-xl font-bold">Your Ultimate Guide to Theatre and Cinema Experiences!</p>
      </div>
      <img src={Arrow} alt="like" className=' size-[3rem]'/>
      <div className="flex flex-col gap-[1.5rem]">
        {visibleRepresentations.map((representation, index) => (
          <Post
            key={`${representation.spectacle_id}-${index}`}
            data={{
              name: representation.spectacle_title,
              description: representation.spectacle_synopsis,
              likes: 0, // You might want to add this to your API response
            }}
            position={index}
          />
        ))}
      </div>
      {position < representations.length && (
        <div ref={ref} className="text-center mt-6">
          <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-500"></div>
        </div>
      )}
    </div>
  );
}

export default InfiniteScroll;
