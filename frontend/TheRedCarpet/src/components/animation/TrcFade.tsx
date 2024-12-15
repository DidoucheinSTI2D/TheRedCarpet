import React from "react";
import { motion } from "motion/react";
import { type ReactNode } from "react";

interface LbFadeProps {
  children: ReactNode;
  fullWidth?: boolean;
  duration?: number;
  delay?: number;
  styles?: Record<string, unknown>;
}

export const LbFade = ({
  children,
  fullWidth,
  duration = 0.5,
  delay,
  styles,
}: LbFadeProps) => (
  <motion.div
    animate={{ opacity: 1 }}
    initial={{ opacity: 0 }}
    transition={{ duration, delay, ease: "easeInOut" }}
    style={{ width: fullWidth ? "100%" : "auto", ...styles }}
  >
    {children}
  </motion.div>
);
